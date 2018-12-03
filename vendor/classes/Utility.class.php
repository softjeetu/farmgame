<?php
/**
 * Created by PhpStorm.
 * User: jitendra
 * Date: 01/12/18
 * Time: 11:20 AM
 */

namespace classes;
use classes\DB as _db;

class Utility{

    /*private variable db for database instance*/
    private $db;


    /*
     * @def configuration varriable
     * @scope public
     */
    public $config;
    /**
     *   Default Constructor
     *
     *	Connect to database & storing instance to db varriable.
     *
     */
    public function __construct(){
        //starting session
        session_start();
        //parsing app configuration ini file & geeting all app configuration
        $this->config = parse_ini_file(BASEPATH.'app.ini');
        //creating & connecting database instance
        $this->db = new _db($this->config);
    }

    /**
     * Parses the URL address and creates appropriate page name to be shown
     * @param array $params The URL address as an array of a single element
     */

    public function process($params)
    {
        //replaceing base url with index.php from the full url  
        $parsedUrl = str_replace(array(BASEURL.'/index.php', BASEURL), array('',''), $params);
        //parsing url
        $_url_arr  =  $this->parseUrl($parsedUrl);
        //getting page name on what basis page will be shown to the user
        $page_name    = $_url_arr[0];
        //checking page name and loading
        if (empty($page_name))
            $this->start_game();
        else if($page_name == 'feed')
            $this->start_feed();
        else // if page name not found
            $this->error_404();
    }


    /**
     * Parses the URL address using slashes and returns params as array
     * @param string $url The URL address to be parsed
     * @return array The URL parameters
     */
    private function parseUrl($url)
    {
        // Parses URL parts into an associative array
        $parsedUrl = parse_url($url);
        // Removes the leading slash
        $parsedUrl["path"] = ltrim($parsedUrl["path"], "/");
        // Removes white-spaces around the address
        $parsedUrl["path"] = trim($parsedUrl["path"]);
        // Splits the address by slashes
        $explodedUrl = explode("/", $parsedUrl["path"]);
        return $explodedUrl;
    }


    /**
     * @param string $url Redirects to a given URL
     */
    private function redirect($url)
    {
        header("Location: $url");
        header("Connection: close");
        exit;
    }

    /**
     * @def error 404 page not found
     */

    private function error_404(){
        $title = '404';
        include(VIEWPATH.'header.php');
        include(VIEWPATH.'404.php');
        include(VIEWPATH.'footer.php');
    }

    /*
     *@def To start new game session
     */

    private function start_game_session(){
        //start the game session            
        if(!isset($_SESSION['game_id']) && isset($_POST['start'])){
            $_SESSION['game_id'] = uniqid('FG',true);
            unset($_SESSION['last_game_id']);
        }
        elseif(!isset($_SESSION['game_id']) && isset($_SESSION['last_game_id'])){
            $_SESSION['game_id'] = $_SESSION['last_game_id'];
        }
        //if game session is not start       
        if(!isset($_SESSION['game_id'])){
            $this->redirect(BASEURL);
        }
    }

    /*
     *@def start_game function show the index page content
     */
    private function start_feed(){
        $title = 'Feed';
        $header_text = "This is Feed Page";
        $info_text = "Red Color indicates to dead object.";
        /*
        * getting all farm objects
        * e.g. Farmer, Cow, bunny
        */
        $farm_objects = $this->get_all_farm_objects();
        // starting game session
        $this->start_game_session();
        /*
        * feeding to the farm objects
        * system will choose randomaly whom to feed      
        */
        if(isset($_POST['feed'])){
            if($this->feed()){
                //inserting dead object into died_object table                                    
                $this->insert_died_object();
            }
            // if feeding is completed to the result page
            else{
                $this->redirect(BASEURL.'/feed');
            }
        }
        //getting total feed records after feeding       
        $feed_records = $this->get_feed_records();
        //getting total dead records after feeding       
        $died_records = $this->get_died_objects();
        /*check if game is over (if returns 1 => lost, if returns 2 => won else game is running)*/
        $is_game_over = $this->_check_game_over($feed_records, $farm_objects);
        include(VIEWPATH.'header.php');
        include(VIEWPATH.'feed.php');
        include(VIEWPATH.'footer.php');
    }

    /*
     *@def start_game function show the index page content
     */
    private function start_game(){
        $title = 'Home';
        $header_text = "Welcome to Farm Game";
        include(VIEWPATH.'header.php');
        include(VIEWPATH.'index.php');
        include(VIEWPATH.'footer.php');
    }


    /*
     *@def feed to perfom full action
     */
    private function feed(){

        if(isset($_SESSION['game_id'])){
            //getting alive objects
            $alive_objects = $this->get_alive_objects();
            //getting random values from alive_objects array
            $random_alive_objects = array_rand($alive_objects);

            //random object to insert into game table
            $random_object = $alive_objects[$random_alive_objects];

            //all feed record into the current game session
            $current_game_feeds = $this->get_feed_records();
            // inserting random objects into game table if round is less than 50
            if($random_object && sizeof($current_game_feeds) < 50){
                $qry = "INSERT INTO game SET farm_object_id = :fid, game_id = :gid";
                return $this->db->query($qry, array('fid' => $random_object, 'gid' => $_SESSION['game_id']));
            }
            else{
                return false;
            }
        }
        return false;
    }


    /*
     *@def get alive object
     */
    private function get_alive_objects(){
        if(isset($_SESSION['game_id']))
        {
            //getting all farm objects
            $farmobjects  = $this->get_all_farm_objects();

            //getting farm object id into an array
            $farm_objects = array_map(function($v){
                return $v['id'];
            },$farmobjects);

            //getting died objects
            $died_objects_array = $this->get_died_objects();

            //finding alive objects
            return array_diff($farm_objects, $died_objects_array);
        }
        return array();
    }

    /*
     *@def get all farm object
     */
    private function get_all_farm_objects(){
        /* getting all farm objects*/

        $q = "SELECT * FROM farmobjects";
        return $this->db->_fetch_all($q);
    }


    /*
     *@def get random object
     */
    private function get_died_objects(){
        $died_objects_array = array();
        if(isset($_SESSION['game_id']))
        {
            /* getting died objects*/
            $q = "SELECT farm_object_id FROM died_object WHERE game_id = :id";
            $died_objects = $this->db->_fetch_all($q, array('id' => $_SESSION['game_id']));
            //storing farm object id into an array
            foreach ($died_objects as $key => $value) {
                $died_objects_array[] = $value['farm_object_id'];
            }
        }
        return $died_objects_array;
    }

    /*
     *@def get feed records
     */
    private function get_feed_records(){
        $game_feed_records = array();
        /* getting feed records*/
        if(isset($_SESSION['game_id'])){
            $q = "SELECT * FROM game WHERE game_id = :id ORDER BY id ASC";
            $game_feed_records = $this->db->_fetch_all($q, array('id' => $_SESSION['game_id']));
        }
        return $game_feed_records;
    }

    /*
     *@def get feed records
     */
    private function insert_died_object(){
        /*query for getting & inserting data into died object table*/
        if(isset($_SESSION['game_id'])){
            /*
             * #1055 - Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column
             * which is not functionally dependent on columns in GROUP BY clause;
             * this is incompatible with sql_mode=only_full_group_by in  5.7 version
             */
            $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            /*
             * inserting died reocrds
             * this query contains dead logic, find the round where object dead & inserting into died_object table
             */
            $q = "INSERT INTO died_object (farm_object_id, game_id)
                    SELECT id AS farm_object_id, :game_id AS game_id
                    FROM
                    (
                        SELECT farmobjects.*, lg.game_pk_id, lg.farm_object_id, lg.game_id
                            ,IFNULL(lg.round_number,0) AS round_number, 
                            (SELECT count(id) FROM game WHERE game_id = :game_id_1) as total_round    
                            FROM farmobjects 
                            LEFT JOIN 
                            (
                                SELECT g.id AS game_pk_id, g.farm_object_id, g.game_id, g.round_number    
                                FROM 
                                  (
                                      SELECT *,(@cnt := @cnt + 1) AS round_number FROM `game` CROSS JOIN (SELECT @cnt := 0) AS dummy WHERE game_id = :game_id_2 
                                      ORDER BY id DESC, round_number DESC
                                  ) as g
                                GROUP BY g.farm_object_id DESC
                            ) AS lg ON farmobjects.id = lg.farm_object_id
                    ) r WHERE (CASE WHEN type = 'farmer' AND (total_round - round_number) >= 15 THEN 1
                                 WHEN type = 'cow' AND (total_round - round_number) >= 10 THEN 1
                                 WHEN type = 'bunny' AND (total_round - round_number) >= 8 THEN 1
                                 ELSE 0
                                END ) = 1
                    ON DUPLICATE KEY UPDATE game_id = :game_id_3";
            return $this->db->query($q, array('game_id' => $_SESSION['game_id'],
                'game_id_1' => $_SESSION['game_id'],
                'game_id_2' => $_SESSION['game_id'],
                'game_id_3' => $_SESSION['game_id']
            ));
        }
        return false;
    }

    /*@def check if game is over*/
    private function _check_game_over($feed_records, $farm_objects){
        if(isset($_SESSION['game_id']))
        {
            /*
            * getting all alive objects types
            * getting all alive objects types from farm objetcs array                  
            */
            $alive_objects = $this->get_alive_objects();
            $alive_objects_type = array_map(function($v) use ($farm_objects){
                return $farm_objects[array_search($v, array_column($farm_objects, 'id'))]['type'];
            }, $alive_objects);

            // getting if all winning objetcs are alive
            $_winning_alive_objects =  array_intersect(array('farmer','cow','bunny'), $alive_objects_type);

            //check if farmer is died
            if(!in_array('farmer', $alive_objects_type)){
                $this->game_over();
                return 1;
            }
            // check if 50 round is completed
            else if(sizeof($feed_records) >= 50){
                $this->game_over();
                // check if winning condition is fullfill                
                if(sizeof($_winning_alive_objects) == 3){
                    return 2;
                }
                else{
                    return 1;
                }

            }
            // check if winning condition is fullfill before completed 50 rounds
            elseif(sizeof($_winning_alive_objects) < 3){
                $this->game_over();
                return 1;
            }
        }
        // if game is running
        return false;
    }

    /*@def unset session if game is over */
    private function game_over(){
        if(isset($_SESSION['game_id']))
        {
            $_SESSION['last_game_id'] = $_SESSION['game_id'];
            unset($_SESSION['game_id']);
        }
    }
}
?>
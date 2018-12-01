# Installation Instructions
- Clone this repo to your server where php & apache is installed
- Create the database and import the farmgame.sql file into the database
- Change the db configuration into app.ini file located at root
- Change the Base url as per your server configuration (e.g. http://localhost/farmgame) into app.ini file located at root
- Run this url directly into your browser


**The game**

*You have a farm with:*

- 1 farmer: needs to be fed at least once every 15 turns.
- 2 cows: each cow needs to be fed at least once every 10 turns.
- 4 bunnies: each bunny needs to be fed at least once every 8 turns.

If any of the animals or the farmer are not fed on time, they die. 
If the farmer dies, all animals die and the game is over.
The game ends after 50 turns. If the farmer and at least one cow and one bunny are still alive at that point, you win.

**How to play**

- There’s a button to start a new game.
- There's a single button to feed the farmer and the animals. Every time you click on that button, the system randomly chooses whom to feed. 
- Every click on this button is a turn. The maximum number of turns is 50. Don't focus on winning or losing, but on building the game as described.


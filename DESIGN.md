# DESIGN

A “design document” for your project in the form of a Markdown file called DESIGN.md that discusses, technically, how you implemented your project and why you made the design decisions you did. Your design document should be at least several paragraphs in length. Whereas your documentation is meant to be a user’s manual, consider your design document your opportunity to give the staff a technical tour of your project underneath its hood.

First off, my decision to use PHP was informed by the constraints of the hosting options available to me. I already had access to a shared hosting plan, but the plan was limited to essentially Wordpress/Weebly sites or PHP. 

Through my research, I was concerned with the dangers of "spaghetti code" that was common to many complaints on the Internet. As such, I took steps to separate code accessing the database from the presentation layer. I focused on an object-oriented approach to the code, by writing classes to handle each table of my database.

Another design choice was using PDO rather than mysqli to access the database. One benefit was that I was able to make a central configuration file containing a DatabaseConnection class, which I used in all subsequent classes I wrote. This helped to minimize redundancy. In addition, PDO allowed me to write code in a way that made SQL injection more difficult, by keeping the variables and the SQL statements separate.

Use of AJAX
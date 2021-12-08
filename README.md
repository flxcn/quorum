# Quorum
An online voting platform for simulating a Constitutional Convention

## Setup

To access Quorum online, go to https://quorumvote.com

To run Quorum locally:

Quorum was built using MAMP as a testing environment.

1. Download MAMP (for Mac users) https://www.mamp.info/en/mac/

2. Download the Quorum project files and place into the htdocs/ folder of MAMP. By default, it is in Applications --> MAMP --> htdocs

3. After the MAMP app is up and running, click "Start" then click "WebStart." Be sure that the settings are on Apache, and that the PHP version is 8.0.8.  Once the localhost homepage has been opened, use the menu to navigate to "Tools" --> "phpMyAdmin" 

4. Once phpMyAdmin is opened, click on the "Import" tab on the top horizontal menu.

5. Choose the quorum.sql file that is included in the project files as the import source, and click "Go." The "quorum" database tables should now have been imported, along with some test data.

6. Double-check that the database settings defined in classes/DatabaseConnection.php are correct. They should reflect the MAMP default configuration, with both database username and password as "root".

7. Now, return to the original localhost MAMP homepage and click on "My Website" (by default, it is at http://localhost:8888). Click on the quorum/ folder, and you should be able to run the project. There are some existing example accounts loaded, but you can also create your own.

## How to Use

### Delegate Perspective

If you don't have an account, you can click on "Open Session" and "Sign up." There, students can input their first and last name, which Caucus they want to belong to, and their email (preferably @college). After creating an account, they can sign in, which will take them to the Delegate dashboard. 

Here, Delegates can mark themselves present for quorum purposes, and monitor for any ongoing votes. When ongoing votes are opened, Delegates can either vote as an individual or vote to represent their caucus. Once they have voted in either, they can confirm their vote by checking the "My Record" tab, where past votes in which the Delegate participated will appear, along with their decision. By design, Delegates can cast a yea, nay, or abstain vote, but Caucuses can only cast a yea, or nay vote (choosing not to vote will be interpreted as a nay vote).

Throughout a simulated conference/convention, Delegates can monitor to see how many yea votes they have remaining. This is a feature unique to the mock Constitutional Convention the platform is designed for, which is the specific one held by "The Democracy Project," which caps the number of yea votes Delegates and the Caucuses they are a part of have.

### Moderator Perspective

If you don't have an account, you can click on "For Staff" and "Sign up." Here, Moderators, which are the users who are running the simulated convention and the voting, can input their user details to create an account. After creating an account, they can sign in, which will take them to the Moderator dashboard. 

Moderators can see an overview of all delegates, including a status indicator of whether an individual delegate is present or absent. For caucuses, Moderators can also see the full list and create new ones if necessary. 

Moderators are able to create, edit, and view Votes. Moderators can toggle the settings on a vote in order to open them for individual delegate voting, caucus voting, or both. Moderators can also edit the details of a vote, by describing the title of the vote, the description, the URL link to a relevant document, the sponsor of the vote, etc. While a vote is ongoing, a Moderator can also track who has voted what stance using the "View Details" button. 

Finally, Moderators can present the results, in the format of a C-SPAN (in this case, H-SPAN) broadcast style, in which the status of a vote's passage can be determined. The thresholds for a vote's passage include three-fourths of voting delegates, and two-thirds of all caucuses present.
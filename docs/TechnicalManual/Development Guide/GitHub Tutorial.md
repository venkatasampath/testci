## Git & GitHub

### Accessing the Repository via Web
The CoRA Repository resides at https://github.comSachinPawaskarUNO/cora25.git. An invitation to be able to access this private repository has to be made before you can view it on GitHub. 

### Creating a New Branch and Pull Latest Code to New Branch

Creating a branch allows you to isolate your development work from other branches in the repository. 
1. On the lower right corner in PhpStorm, click on Git Branch. 
2. Click "New Branch" and give it a meaningful name i.e. AmandaSprint5Branch. You will now see your new branch name on the lower right corner. 
3. Click on ***VCS*** on the top menu bar and choose ***Git*** then choose ***Pull***
4. You need to specify which branch you want to pull from. If you are doing this for the first time, you need to pull from the master branch. If you are doing this during sprint iterations, pull from the latest sprint. Click the **Pull** button after you have chosen which sprint to pull from.

	*Note: If you do not see the branch you're looking for press control + F5 to update branches.*

### Committing Code to Your Branch

After working on your code in your local development environment. It is good practice to commit your code to your branch. This part is also required to be able to push your development to GitHub. 

1. Click the green check mark on the top right of your screen. Alternatively, you can choose ***VCS*** from the top menu and choose ***Commit***. 
2. On the left hand side you will see what changes you made on your local environment that you want to commit. Only commit the files that you have worked on. **NEVER COMMIT app,js or mix-manifest.json FILE.** Check the boxes of files you want to commit. 
3. Enter a comment or description of what you are committing on the bottom left of the screen. 
4. Press the ***Commit*** button
5. You may see a popup that states a number of files contain problems. Review the code to make sure there are no issues. If no issues are found then proceed with clicking the Commit button. 

### Push Code to GitHub
1. After the code has been committed, you need to push the code to GitHub. Click VCS on the top menu then click on Git then click on Push. Alternatively, you can click on the green sideways upward arrow button on the top right of PhpStorm. 
2. A screen with the code that you want to push will appear. Review and make sure they are the files you want to push to GitHub. Remember to **NEVER PUSH app,js or mix-manifest.json FILE.** If you see these files, revert your commit and start over. Press the ***Push*** button when you're ready to push to GitHub. 
3. On the bottom right of the screen you can see the status of the push. If there is an error, you will see a notification. 

### Create a Pull Request to the Sprint Branch

1. Log into GitHub at https://github.com/SachinPawaskarUNO/cora25. You should see a notification upon logging in ***"Your Branch Name had recent pushes (time) ago."*** Click on the green button that says **"Compare & pull request"**
2. On the "Open a pull request" page you will see base: master <- compare: your branch name. **NEVER PULL AGAINST THE MASTER BRANCH**. Change the dropdown of base: master to the sprint branch you need to merge your code to. The compare: your branch name should show your branch name that you recently pushed from in your local environment, if it does not, change it. 
3. Write a short descriptive comment of what you are trying to merge and what changes were made. 
4. On the right side of the screen under "Reviewers", enter the name of the designated person who can approve pull requests
5. Click the button "Create pull request"

### GitHub Video Tutorial 


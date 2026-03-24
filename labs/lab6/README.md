Lab 6 - jQuery

In this lab I learned to use jQuery to apply functions to a website.

I added fucntions where

- problem 1: when "your name" is clicked it will change to my name "Christopher Hernandez

- problem 2: button which will make the pargraph appear or dissapear when clicked

- problem 3: turn list iteam red when clicked and revert to normal when clicked again

- problem 4: button which will add list iteams

- problem 5: toggle button which will hide/show text

Problem 5 Explanation 

At first When a new list iteam was added to the list, clicking on the added list iteams would 
not turn red like the original 5 would when clicked on

This is because I originaly wrote the code where jQuery would run the specific line once and would only attach the
logic to the existing list elements and would not apply to any new list elements added. 

I fixed it by using .on() which would apply the logic to the parent (#labList) so when a new list is added,
since its in the (labList) it would have the logic applied to it.

- Homepage: http://hernac7rpi.eastus.cloudapp.azure.com/iit/labs/lab4/web.html
- Lab 6 page: http://hernac7rpi.eastus.cloudapp.azure.com/iit/labs/lab6/lab6.html
- GitHub repo: https://github.com/ChrisJH07/itws1100-hernac7

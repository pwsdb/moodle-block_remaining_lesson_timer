
                                ======================
                                Remaining Lesson Timer
                                ======================
 written in 2011 
 updated through 2018-07

This side block displays the elapsed and remaining time, to a tenth of a minute, in a 
timed lesson.  It will display "Time Completed" after the time limit has been reached.
There is a "REFRESH TIMER" option which refreshes the page and updates the timer.

"Remaining_lesson_timer" is for all current moodle versions through ver. 3.6 and is 
backward compatible through moodle version 2.1

Ver. 2.x:
If a time limit on the moodle lesson has been set the side-block will display.  If
the time limit is not "Enabled" the student will not be thrown out and may continue.

Ver. 3.x:
If "Activity completion" has been activated with at least "Require time spent" (set 
greater than 0) the side-block will display.

The Remaining Lesson Timer code restricts its display to lesson module pages so that 
an administrator can simply have one instance that covers all courses ["Display 
throughout the entire site"] and it will show up in and only in lessons where the time 
limit is set [greater than 0].  

If a person is not enrolled in a course with timed lessons, for ex. an admin or teacher, 
then there are no {lesson_timer} records but so that you can see that it is running, the 
timer will simply display the required time to be spent and 0 for the actual time spent.  
No records are written by this timer display.  

Note:
The "REFRESH TIMER" option is not displayed on the first page of a lesson because till 
moodle 3.3, refreshing the first page causes the elapsed time to get zeroed out and 
trying to refresh the continue.php causes a browser warning against resending data and 
repeating actions.

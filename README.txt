
                                ======================
                                Remaining Lesson Timer
                                ======================
 written in 2011 
 updated through 2018-07

Remaining Lesson Timer,  version 3 
----------------------------------
By Greg Smith   {@link http://www.pwsdb.com} 
for   {@link http://TomWilsonCounseling.com}
This side block "remaining_lesson_timer" is for all current moodle versions through 
ver. 3.6 and is backward compatible through moodle versions 2.

This side block displays the elapsed and remaining time, to a tenth of a minute, in a 
timed lesson.  It will display "Time Completed" after the time limit has been reached.
There is a "REFRESH TIMER" button which refreshes the page and updates the timer.

Ver. 2.x:
If a time limit on the moodle lesson has been set the side-block will display both
the time spent and the time remaining in minutes to a tenth of a minute.  If
the time limit is not "Enabled" the student will not be thrown out and may continue.
It will display "Time Completed" 1 second after the time limit has been reached.


Ver. 3.x:
If "Activity completion" has been activated with at least "Require time spent" (set 
greater than 0) the side-block will display.

The Remaining Lesson Timer code restricts its display to lesson module pages so that 
an administrator can simply have one instance that covers all courses ["Display 
throughout the entire site"] or a person can be more selective.  In either case, it 
will show up in and only in lessons where the time limit is set [greater than 0].  

If a person is not enrolled in a course with timed lessons, for ex. an admin or teacher, 
then there are no {lesson_timer} records but so that you can see that it is running, the 
timer will simply display the required time to be spent and 0 for the actual time spent.  
No records are written by this timer display.  

there are two html classes that can be used to change the text displayed:
class=update  on  "REFRESH TIMER" (which will be the default color of a link otherwise)
class=completed  on   "Time Completed" 

Note:
The "REFRESH TIMER" button is not displayed on the first page nor on a continue.php page 
of a lesson because till moodle 3.3, refreshing the first page causes the elapsed time 
to get zeroed out and trying to refresh the continue.php causes a browser warning against 
resending data and repeating actions.

-----------------------------------------------------------------------------------------
    Default installation instructions for plugins of the type Blocks

    Make sure you have all the required versions.
    Download and unpack the block folder.
    Place the folder (eg "myblock") in the "blocks" subdirectory.
    Visit http://yoursite.com/admin to complete the installation
    Turn editing on in any home or course page.
    Add the block to the page
    Visit the config link in the block for more options.



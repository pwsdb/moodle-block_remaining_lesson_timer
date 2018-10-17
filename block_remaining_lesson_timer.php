<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Block for displaying the elapsed and remaining time in a timed lesson
 *
 * @package    block_remaining_lesson_timer
 * @copyright  2007 onwards Greg Smith,   {@link http://TomWilsonCounseling.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Greg Smith, Florida
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Displays remaining time in a lesson.
 * @copyright  2007 onwards Greg Smith,   {@link http://TomWilsonCounseling.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_remaining_lesson_timer  extends block_base {

    /**
     * Set the initial properties for the block.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_remaining_lesson_timer');
    }

    /**
     * Set the applicable formats for this block to all
     * @return array
     */
    function applicable_formats() {
        return array('site-index' => true,
                            'mod' => true,
                    'lesson-view' => true,
                    'course-view' => true);
    }

    /**
     * Allow the user to configure a block instance
     * @return bool Returns true
     */
    function instance_allow_config() {
        return true;
    }

    /**
     * Return the content of this block.
     * @return stdClass the content
     */
    function get_content() {

        global $CFG, $USER, $DB;

        if ($this->content !== null) :
            return $this->content;
        endif;
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        // This block-program will not run unless called by lesson/view.php.
        // else, terminate: return no content, end.
        if (stripos($_SERVER['SCRIPT_FILENAME'], 'lesson/view')) {

            $id = required_param('id', PARAM_INT);
            $querycml =
               "SELECT  cm.id AS cmid,  cm.module,  cm.instance,
                        cm.section,  l.*
                  FROM  {course_modules}  cm
                  JOIN  {lesson} l
                    ON  ( l.id = cm.instance  AND  cm.course = l.course )
                 WHERE  cm.id = :id
                   AND  cm.module = 11 ";

            $lesson = $DB->get_record_sql($querycml, array('id' => $id));
            if ($lesson) {
                if ( isset($lesson->maxtime) ) :
                    $requiredtime = $lesson->maxtime;
                else:
                    $requiredtime = (int)($lesson->completiontimespent / 60);
                endif;

                if ($requiredtime > 0 ) {
                    $ttltime = 0;
                    $highscore = 0;
                    // To display the first 20 characters of the lesson title-name.
                    $lsnname = substr($lesson->name, 0, 20);
                    $queryttltime =
                        "SELECT  lessontime,  starttime,  SUM(lessontime - starttime) AS ttl
                           FROM  {lesson_timer}
                          WHERE  userid = :userid
                            AND  lessonid = :lessonid ";

                    $lessonlogs = $DB->get_record_sql($queryttltime, array('userid' => $USER->id, 'lessonid' => $lesson->id ));

                    if ($lessonlogs) :        // Get the time spent: $ttltime is in minutes  ->ttl is in seconds.
                        if ($lessonlogs->ttl > 1 ) :
                            $ttltime = floor(($lessonlogs->ttl - 1) / 6);
                            // Mdl logic is ">", not ">=" therefore "-1" before truncating and rounding.
                        else:
                            $ttltime = floor($lessonlogs->ttl / 6);
                            // Floor(#/6) rounds a number(#) DOWN to the tenth of a minute.
                        endif;
                        $ttltime = ($ttltime / 10);
                    endif;
                } // 5 end if ($requiredtime > 0 )
            } // 4 end if ($lesson)

            if ($requiredtime > 0 ) {
                $strrequiredtime  = get_string('requiredtime',  'block_remaining_lesson_timer');
                $strtimeremaining = get_string('timeremaining', 'block_remaining_lesson_timer');
                $strtimespent     = get_string('timespent',     'block_remaining_lesson_timer');
                $strtimecompleted = get_string('timecompleted', 'block_remaining_lesson_timer');
                $strminutes       = get_string('minutes',       'block_remaining_lesson_timer');
                $this->content->text .= '  '.$lsnname.'... ';
                $this->content->text .= '  <p> '.$strrequiredtime.' <br> '.$requiredtime.' '.$strminutes.' </p> ';
                if ( $ttltime > $requiredtime ) {
                    $this->content->text .= '<p class=completed> <br> '.$strtimecompleted.'  </p> ';
                } else {
                    $this->content->text .= ' <p> '.$strtimespent.': '.$ttltime.' '.$strminutes.' ';
                    $this->content->text .= ' <br> <span class=minutestogo> '.$strtimeremaining.': '.
                                            ($requiredtime - $ttltime).' '.$strminutes.' </span> </p> ';

                    $pageid = (int)optional_param('pageid', null, PARAM_INT);

                    if ( $pageid > 0 )
                        $this->content->text .= ' <div class=refresh> <a  title="refresh / reload current page" ' .
                                'href='. $CFG->wwwroot . '/mod/lesson/view.php?id='.$id.
                                '&pageid='.$pageid.'> REFRESH TIMER </a></div>';
                        // Refreshing view.php updates the timer except on the first page of a lesson
                        // On the first page, till moodle 3.3 the timer does not increment. It zeros the saved time!
                        // The continue.php causes a browser warning against resending data and repeating actions
                } // 5 end if ( $ttltime > $requiredtime )
            } // 4 end if ($requiredtime > 0 )

        } // 3 end if (stripos($_SERVER['SCRIPT_FILENAME'], 'lesson/view'))

        return $this->content;
    } // 2 end function get_content()

}



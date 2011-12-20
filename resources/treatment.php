<?php
/**
 * /----------------------------\
 * | Group # | gender | athlete |
 * | Group 1 |    x   |         |
 * | Group 2 |    x   |     x   |
 * | Group 3 |        |     x   |
 * | Group 4 |        |         |
 * \----------------------------/
 */

require_once "config.php";

echo "<h2>Treatment Groups</h2><hr/>";
echo "<ol><li>Male &amp; Non-Athlete</li>";
echo "<ul>".assign_treatment(1, 0)."</ul>";
echo "<li>Male &amp; Athlete</li>";
echo "<ul>".assign_treatment(1, 1)."</ul>";
echo "<li>Female &amp; Athlete</li>";
echo "<ul>".assign_treatment(0, 1)."</ul>";
echo "<li>Female &amp; Non-Athlete</li>";
echo "<ul>".assign_treatment(0, 0)."</ul>";
echo "</ol>";


?>
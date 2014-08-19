<?php
/**
 * To execute this example you need to install the library with composer in order
 * to use the autoload in this include file.
 * If you dont wanna use composer just include each file from the src directory.
 */
include '../vendor/autoload.php';

$cal = new \SSC\Calendar();

$cal->day_callback = function($date){
    $day = new stdClass();
    $day->has_passed = $date->getTimestamp()<time();
    return $day;
};

$structure = $cal->getCalendarStructure();

?>
<h1>Spanish calendar</h1>

<?php foreach($structure as $year): ?>
    <?php foreach($year['elements'] as $quarter): ?>
        <?php foreach($quarter['elements'] as $month): ?>
            <div>
                <?php echo $year['value']; ?> - <?php echo $month['value']; ?>
                <table>
                    <tr>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fra</th>
                        <th>Sun</th>
                        <th>Sat</th>
                    </tr>
                    <?php foreach($month['elements'] as $week): ?>
                        <tr>
                            <?php foreach(array(1,2,3,4,5,6,0) as $weekday): ?>
                                <td>
                                <?php foreach($week['elements'] as $day): ?>
                                    <?php if($day['weekday'] == $weekday): ?>
                                        <?php echo $day['value'];?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endforeach; ?>

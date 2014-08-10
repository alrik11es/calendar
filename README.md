Stupidly Simple Calendar
======================

Stupidly Simple Calendar a.k.a. "SSC" is a PHP calendar structure generator in array, object or JSON format.

##Motivation

Do you remember those long... long... hours trying to create a rendered calendar? Think about this, the main problem is that you have to generate the structure for do the rendering in your template engine, no matter what it is. So the thing is I don't wanna give you a fully rendered calendar just the structure you need to do the render. How do you do to render it... it's all on you.

##How it works
Lets gets into business lets set up a calendar from today to 6 months into the future:

```php
$cal = new \SSC\Calendar();
$structure = $cal->getCalendar();

print_r($structure);
```

The output then is like the next one:

```
Array
(
[2014] => Array
    (
    [type] => year
    [value] => 2014
    [data] =>
    [elements] => Array
        (
        [3] => Array
            (
            [type] => quarter
            [value] => 3
            [data] =>
            [elements] => Array
                (
                [8] => Array
                    (
                    [type] => month
                    [value] => 8
                    [data] =>
                    [elements] => Array
                        (
                        [31] => Array
                            (
                            [type] => week
                            [value] => 31
                            [data] =>
                            [elements] => Array
                                (
                                [1] => Array
                                    (
                                    [type] => day
                                    [value] => 1
                                    [data] => stdClass Object
                                        (
                                            [has_passed] => 1
                                        )

                                    [weekday] => 5
                                    )
```

Then you just have to take it and render in your Twig or whatever... (Next one is the spanish way, but you can change to whatever you want)

```php
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
```

Bam! Calendar!

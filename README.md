UCNU Calendar [![Build Status](https://travis-ci.org/alrik11es/calendar.svg?branch=master)](https://travis-ci.org/alrik11es/calendar)
======================

[![Latest Stable Version](https://poser.pugx.org/alrik11es/calendar/v/stable.svg)](https://packagist.org/packages/alrik11es/calendar) [![Total Downloads](https://poser.pugx.org/alrik11es/calendar/downloads.svg)](https://packagist.org/packages/alrik11es/calendar) [![Latest Unstable Version](https://poser.pugx.org/alrik11es/calendar/v/unstable.svg)](https://packagist.org/packages/alrik11es/calendar) [![License](https://poser.pugx.org/alrik11es/calendar/license.svg)](https://packagist.org/packages/alrik11es/calendar)

UCNU Calendar is a PHP calendar structure generator in array, object or JSON format.

* [Installation](#installation)
    * [Requirements](#requirements)
    * [With composer](#with-composer)
* [How it works](#how-it-works)

## Motivation

Do you remember those long... long... hours trying to create a rendered calendar? Think about this, the main problem is that you have to generate the structure to do the rendering in your template engine, no matter what it is. So the thing here is I don't wanna give you a fully rendered calendar just the structure you need to do the render. How do you do the render... it's all on you.

Take a look to this example render:

![Calendar example](img/calendar.png "Calendar example")

## Installation

### Requirements

- Any flavour of PHP 5.4+ should do
- [optional] PHPUnit to execute the test suite

### With Composer

The easiest way to install SSC is via [composer](http://getcomposer.org/). Create the following `composer.json` file and run the `php composer.phar install` command to install it.

```json
{
    "require": {
        "ucnu/calendar": "0.1.*"
    }
}
```

### No composer

Git clone this repo where you want and include/require all the src folder into your project.

## How it works
Lets get into business. Set up a calendar from today to 6 months into the future:

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
                                    [data] => 
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

# Bam! Calendar!

Oh BTW I can give you a Twig example Just for the record :P

```php
$cal = new \SSC\Calendar();
$cal->getConfig()->setInterval(new \DateInterval('P12M'));
$cal->day_callback = function($date){
    $day = new \stdClass();
    $day->has_passed = $date->getTimestamp()<time();
    return $day;
};

// Spanish months (There is tons of ways of doing this but...)
$context['months_es'] = array(
    1=>'Enero', 'Febrero', 'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
);
// The week days order. In spanish calendar this is different than in english.
$context['week_days'] = array(1,2,3,4,5,6,0);
// The calendar structure...
$context['cal'] = $cal->getCalendarStructure();
```

Yeah, the Twig file...

```twig
{% for year in cal %}
    {# You could add here the years #}
    {% for quarter in year.elements %}
        {% for month in quarter.elements %}
        <table class="month">
            <tbody>
            <tr>
                <th colspan="9" class="month-title">{{ year.value }} - {{ months_es[month.value] }}</th>
            </tr>
            <tr>
                <th>L</th>
                <th>M</th>
                <th>X</th>
                <th>J</th>
                <th>V</th>
                <th class="thweekend">S</th>
                <th class="thweekend">D</th>
            </tr>
            </tbody>

            {% for week in month.elements %}
                <tr>
                    {# You could add here the week number #}
                    {% for week_day in week_days%}
                        <td class="day-container">
                            {% for day in week.elements %}
                                {% if day.weekday == week_day %}
                                    <div class="day {% if day.data.has_passed %}passed_day{% endif %} {% if week_day == 6 or week_day == 0 %}weekend{% endif %}">
                                        {{ day.value }}
                                    </div>
                                {% endif %}
                            {% endfor %}
                        </td>
                    {% endfor %}
                </tr>
            {% endfor %}
        </table>
        {% endfor %}
    {% endfor %}
{% endfor %}
```
# Vue.js

With the boom of this kind of libraries just like angular or react. I give you an example of how a render should look like. Obviously you will need to make the API part. But at least this is a good starting point.

```html
<template>

    <div>
        <div v-for="year in calendar">
            <!--<div>{{year.value}}</div>-->
            <div v-for="quarter in year.elements">
                <div v-for="month in quarter.elements" class="month">
                    {{ year.value }} - {{ month.value }}
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
                        <tr v-for="week in month.elements">
                            <td v-for="weekday in [1,2,3,4,5,6,0]">
                                <div v-for="day in week.elements">
                                    <span v-if="day.weekday == weekday">
                                        {{ day.value }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                calendar: {},
            }
        },
        methods: {
        },
        mounted() {
            axios.get('/api/calendar').then(response => {
                this.calendar = response.data;
                console.log(this.calendar);
            }).catch(e => {
            });
        }
    }
</script>


<style scoped lang="sass">
    .month{
        float: left;
        margin: 10px;
    }
</style>
```

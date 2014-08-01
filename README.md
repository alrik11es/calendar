Stupid Simple Calendar
======================

Stupid Simple Calendar a.k.a. "SSC" is a PHP calendar structure generator in array, object or JSON format.

##Motivation

Do you remember those long... long... hours trying to create a rendered calendar? Think about this, the main problem is that you have to generate the structure for do the rendering in your template engine, no matter what it is. So the thing is I don't wanna give you a fully rendered calendar just the structure you need to do the render. How do you do to render it... it's all on you.

##How it works
Lets gets into business lets set up a calendar from today to 6 months into the future:

```php
$cal = new \SSC\Calendar();
$structure = $cal->getCalendar();

print_r($structure);
```

The output then is the next one:

```

```

Then you just have to take it and render in your Twig or whatever...

```twig

```

Bam! Calendar!

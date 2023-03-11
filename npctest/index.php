<?php
$http_host=getenv("HTTP_HOST");
if (stristr($http_host, 'strfpak-wiki')!="") {
  header ("Location: http://strfpak-wiki.berkeley.edu/mediawiki/index.php");
  exit;                 /* Make sure that code below does not execute */
}



// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

?>
<HTML>
<HEAD>
<META name="verify-v1" content="4yv5QtRxMQyJpSAO9p0CnI94E4w1cDGiagZUqtbDQE4=" />
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="description" content="The Neural Prediction Challenge">
<meta name="keywords" content="">
<meta name="author" content="root">
<meta name="verify-v1" content="8zXcoZ6PTskLlY2yn38ndu3snZfqhoRAlHgtZWWInSs=" />
<link rel="stylesheet" type="text/css" href="andreas02.css" media="screen,projection" title="andreas02 (screen)">
<link rel="stylesheet" type="text/css" href="print.css" media="print"><title>The Neural Prediction Challenge</title></head>

</HEAD>
<body>

<div id="toptabs">
<p>Sites:
<a class="toptab" href="http://strfpak.berkeley.edu/">STRFPak</a><span class="hide"> | </span>
<a class="activetoptab" href="index.php">Challenge</a><span class="hide"> | </span>
</p></div>

<div id="container">
<div id="logo">
<!-- <h1><center><a href="index.php">TITLE</a></center></h1> -->
</div>

<div id="navitabs">
<a class="activenavitab" href="index.php">Challenge</a><span class="hide"> | </span>
<a class="navitab" href="rul.php">Rules</a><span class="hide"> | </span>
<a class="navitab" href="faq.php">FAQ</a><span class="hide"> | </span>
<a class="navitab" href="con.php">Contact</a><span class="hide"> | </span>
</div>

<div id="desc">
<!-- <h2>SUMMARY</h2> -->
</div>
  
<div id="main">


<h3>The idea behind the neural prediction challenge</h3>

<h4>Motivation</h4>

<p>One important goal of any field of science is to develop a theory
(or model) that predicts future outcomes. In the particular case of
computational and systems neuroscience, we seek a model that can
predict the activity of neural systems engaged in sensory processing or
behavioral control. The accuracy of a such a model would serve as a
benchmark for our understanding of the brain, as well as a tool for
revealing principles of neural function.</p>

<p>Clearly, an ideal model of the brain would accurately predict the
responses of neurons under natural conditions. But computational
neuroscience has yet to produce models that can describe neural
responses to natural stimuli. Most current neural models have been
constructed based on data collected in classical reductionist
experiments optimized to provide powerful tests of specific hypotheses.
Although such experiments are critical for model construction, real-world
model performance can only be assessed by examining how well a model
predicts neural responses under natural conditions. This
fundamental problem compels the Neural Predection Challenge. The aim of
the Challenge is to accelerate the development of predictive models,
and to provide computational neuroscientists an opportunity to test
their models.</p>

<p>The aim of the Neural Prediction Challenge is to accelerate the
development of predictive models and to provide computational
neuroscientists an opportunity to test their models objectively.</p>

<h4>The Challenge</h4>
<p>The challenge is really quite simple: We will give you some (visual
and/or auditory) stimuli and corresponding neural responses, and you
must try to predict responses to other stimuli. Each data set will be
divided in to two subsets: a fit set (90% of the data) that includes
both the stimuli and the corresponding neuronal responses; and a
validation set (10% of the data) that includes only stimuli (no
responses). Your job is to use the fit set to fit your model and then
to generate predicted responses based on the stimuli provided in the
validation set. Once you have the predictions you should return them to
us. We will compare your predicted responses to the responses actually
observed in the validation set.</p>

<h4>Data</h4>
<p>Current data consist of recordings from visual and auditory neurons
during naturalistic stimulation. (In the future we hope to make
available representative data sets from many different sensory
systems.) Data are provided in simple ascii files that are easily
readable in Matlab (or by any other modern programming language).
Details on data formatting are provided with each data set.</p>

<h4>Predictions</h4>
<p>Predictions will be evaluated continuously as they are received and
results will be posted in aggregate form. Individuals' names,
prediction scores and models will not be posted without prior
permission (though we may contact participants directly, see <a href="http://neuralprediction.berkeley.edu/rul.php">official rules</a>).
Please note that this is an academic research project, it is not a
traditional contest. There is no real ending date, and there is nothing
to win.</p>

<h4>Who Can Participate?</h4>
<p>To ensure that we will be able to give each entry serious
consideration, the challenge will be limited to those working in
computational neuroscience. For this reason these data will only be
distributed to qualified personnel at academic and research
institutions.</p>

<h4>For further information about the Neural Prediction Challenge, please 
see the <a href="http://neuralprediction.berkeley.edu/rul.php">official rules</a>,
read the <a href="http://neuralprediction.berkeley.edu/faq.php">frequently asked questions</a> 
or <a href="http://neuralprediction.berkeley.edu/con.php">email</a> us.</p>

</div>

<div id="sidebar">

<?php
entranceinterface();
?>
<hr>

<h4>News:</h4>
<p>The new web server is up! After you join the challenge you can download
datasets and submit your predictions directly!</p>
<hr>

<h4>Links out:</h4>
<a class="sidelink" href="http://www.neurotree.org/">Neurotree</a><span class="hide"> | </span>
</p>

<br>
<p>This project is supported by the NIH Human Brain Project.</p>

<br>
<p>Site v. 2.0 (March 20, 2006)</p>

</div>
    
<div id="footer">
Site developed and maintained by Jack Gallant, UC Berkeley & Stephen David, U Maryland.
<br>
Copyright 2006 UC Regents.
</div>

</div>
</body></html>


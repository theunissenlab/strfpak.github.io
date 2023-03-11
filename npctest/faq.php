<?php

// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="description" content="The Neural Prediction Challenge">
<meta name="keywords" content="">
<meta name="author" content="root">
<link rel="stylesheet" type="text/css" href="andreas02.css" media="screen,projection" title="andreas02 (screen)">
<link rel="stylesheet" type="text/css" href="print.css" media="print"><title>Neural Prediction</title></head>

<body>
<div id="toptabs">
<p>Sites:
<a class="toptab" href="http://strfpak.berkeley.edu/">STRFPak</a><span class="hide"> | </span>
<a class="activetoptab" href="index.php">Challenge</a><span class="hide"> | </span>
</p></div>

<div id="container">
<div id="logo">
</div>

<div id="navitabs">
<a class="navitab" href="index.php">Challenge</a><span class="hide"> | </span>
<a class="navitab" href="rul.php">Rules</a><span class="hide"> | </span>
<a class="activenavitab" href="faq.php">FAQ</a><span class="hide"> | </span>
<a class="navitab" href="con.php">Contact</a><span class="hide"> | </span>
</div>

<div id="desc">
</div>
  
<div id="main">
<h3>Frequently Asked Questions</h3>
<p>Please be sure to read the <a href="rul.php">rules</a>, your questions might be answered there.</p>

<h4>Why should I register for the challenge?</h4>
<p>Guests (those who have not registered) can enter the site and observe
the current results of the challenge, but they cannot download data or
submit predicitons. These two functions can only be accessed by registered
users.</p>

<h4>Why can't I have all of the data?</h4>
<p>One of the common pitfalls of predictive modeling is the danger of
over-fitting. Overfitting occurs when a predictive model is fit to the
noise (or the stimulus correlations) in a small data set. This will
tend to make predictions look better than they actually are. By holding
back the response data from the validation set, we ensure that your
predictive model cannot overfit to the noise in the validation set.
That allows us to evaluate the predictive power of your model fairly.</p>

<h4>Do I have to send you my model?</h4>
<p>No! The Neural Prediction Challenge is designed so that you don't
have to reveal any proprietary information unless you want to. We send
you the fit data (stimuli and responses) and the validation data
(stimuli only). You only return the predicted responses for the
validation data to us. We do not need to see your model at all!
However, if your model gives excellent predictions the laboratory that
contributed the Challenge data will likely contact you for
further collaboration.</p>

<h4>How will I find out my prediction score, and will anyone else know?</h4>
<p>When you submit a Challenge prediction it will be processed and
evaluated by our computers. Your prediction score will be expressed as
the percentage of explainable variance explained. This score will be
returned to you, and it will be forwarded to the laboratory that
contributed the Challenge data. (That laboratory may contact you to
discuss further collaborations.) In addition, your prediction score
will be posted anonymously on the neural prediction web site, using
your nickname.</p>

<h4>What is my nickname?</h4>
<p>Your neural prediction nickname is your public face on the Challenge
web site. Any predictions that you submit will be identified by your
nickname. We will not reveal your nickname to anyone, so your anonymity
will be protected.</p>

<h4>What is explainable variance?</h4>
<p>Any neural signal can be divided in to two distinct components: the
deterministic part that is predictable from the stimulus, and the
stochastic part that cannot be predicted from the stimulus alone. (The
stochastic part reflects the true noise level, sampling
limitations and other uncontrolled factors.) Because the stochastic
part of the response cannot be predicted from the stimulus alone, it
will never be possible to predict 100% of the total variance in responses.
The <b>explainable variance</b> is the part of the variance that does 
not reflect noise, and is therefore potentially explainable.</p>

<h4>Why do you use the correlation coefficient in calculating explainable variance?</h4>
<p>The correlation coefficient (or the squared correlation, also called
the percentage of variance explained and the proportional reduction in
error) is insensitive to differences in the mean of two variables, and
it assumes that they variables are Gaussian distributed. The first
property seems undesireable for our purposes and the second is clearly
inappropriate for many neural data. Clearly, correlation-based measures
are not the best metrics for describing the relationship between
predicted and observed responses. On the other hand, most
non-correlation-based measures of the relationship between predicted
and observed neural responses are highly correlated with the
correlation coefficient! Because most researchers are already familiar
with the correlation coefficient, we use that measure in calculating
the explainable and explained variance.</p>

<h4>How often can I enter the Neural Prediction Challenge?</h4>
<p>We are still discussing what if any restrictions should be placed on
entries. We generally believe that no restrictions should be placed on
entries, that people should be allowed to enter as often as they like.
On the other hand, we want to avoid any chance that the data might be
overfit by performing gradient descent on the validation data set (think
about it...), so we will throttle submissions by users who submit too
frequently.</p>

<h4>Can I publish the data results of my model predictions?</h4>
<p>This is a complicated issue. The neural prediction challenge is made
possible by the generous contributions of raw data from several
different neuroscience laboratories. Let us refer to the laboratory
that contributed a partcular data set as the <b>contributing laboratory</b>. 
The only restriction on publication of challenge data is that the data may <b>not</b>
be published without the express prior permission of the contributing
laboratory. This restriction is being enforced for the protection of
both you and the contributing laboratory. Obviously, the contributing
laboratory has a vested interest in ensuring that their data are
described accurately and completely; it would be in no one's interest
to publish misinformation about the data themselves or how they were
collected. In addition, some of the Challenge data may be covered by
regulations or other restrictions. Because of the complexity of neural
data we believe that the only way that accuracy can be assured is if
the contributing laboratory takes part in any publication of their
data. We leave it to you and the contributing laboratory to negotiate
the terms of publication. The contributing laboratory may simply
require pre-review of the paper, or they may request that you include
citation(s) to relevant paper(s), or in some cases they may require a
co-authorship. <b>To ensure that this rule is followed, we have
intentionally ommitted many details about these data. We believe that
Challenge data are unpublishable without these details. Thus, if you
want to publish Challenge data you will need to contact the
contributing laboratory in order to obtain the necessary information.</b>
On the other hand, we place no restrictions whatsoever on your
publishing a theoretical paper that describes a predictive model that
you have used in the Neural Prediction Challenge, but which does <b>not</b>
contain data from the Challenge. You are free to publish such models as
you would have if the Challenge had ever occurred. You may also cite
the prediction score that your model achieves in the Challenge, as long
as you cite this web site and state the name of the data set that was
used in prediction.

</p><h4>How do I contact the laboratory that contributed a particular Challenge data set?</h4>
<p>If you submit a good prediction, they will contact you! Whenever you
submit a prediction it is processed and evaluated by our computers, and
the result forwarded to the laboratory that supplied the original data.
That laboratory can then contact contestants who make accurate
predictions for further consultation. If you wish to contact one of the
contributing laboratories directly, please email the site maintainer and
s/he will put you in touch with the contributing laboratory.</p>

<h4>Don't we already have many computational models of neurons?</h4>
<p>There are many theoretical and computational models of neural
systems that aim to account for neuronal function at a variety of
levels: molecular models, compartmental models, network models, models
of specific cell types, specific neural systems or specific
circumstances. However, almost all of these models have been
constructed to account for data collected under highly controlled
experimental conditions. The aim of the Neural Prediction Challenge is
to develop models that can account for sensory processing under
naturalistic conditions.</p>

<h4>Why does this contest only address models of sensory neurons?</h4>
<p>One marked advantage of studying sensory neurons is that we can
guess their general function: to process sensory input. Neurons in
other regions of the brain are farther removed from the sensory input,
so it is more difficult to predict their responses. Fortunately the brain is
built a modular design principles, so that models developed to account for
sensory processing are also likely to be applicable (albeit in modified form)
to non-sensory systems.</p>

<h4>How do I know if I won?</h4>
<p>This is not a contest in the traditional sense, so you cannot really
win. In the larger sense no one really wins until some model explains
100% of the explainable variance. That isn't likely to happen any time
soon. On the other hand, early contestants have expressed interest in
some form of acknowledgement or award for good predictions. We are
looking in to some potential prize or award meeting and will make an
announcement about this in the future.</p>

<h4>Is it "neural" or "neuronal"?</h4>
<p>We generally prefer to use "neural" to refer to more than one
neuron, and "neuronal" to refer to a single neuron. But sometimes
"neural" just sounds better.</p>

</div>

<div id="sidebar">

<?php

if (""==$userid) {
   echo("<h4>Log in here</h4>\n");
   if (""!=$errormsg) {
     echo("<p><b><font color=\"#CC0000\">$errormsg</font></b></p>\n");
   }
   echo("<p>\n");
   echo("<FORM ACTION=\"status.php\" METHOD=POST>\n");
   echo("User ID:<br>\n");
   echo("<INPUT TYPE=TEXT size=12 NAME=\"userid\"><br>\n");
   echo("Password:<br>\n");
   echo("<INPUT TYPE=PASSWORD size=12 NAME=\"passwd\"><br>\n");
   echo("<INPUT TYPE=SUBMIT VALUE=\"GO\">\n");
   echo("</FORM>\n");
   echo("</p>\n");
   echo("<p><a href=\"newaccount.php\">Sign up for an account</a></p>\n");
} else {
   echo("<h4>Logged in as $userid</h4>\n");
   echo("<p><a href=\"status.php\">Go to data!</a></p>\n");
   echo("<p><a href=\"index.php?logout=1\">Log out</a></p>\n");
}
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
Copyright 2006 UC Regents.
</div>

</div>
</body></html>

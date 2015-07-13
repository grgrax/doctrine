<section id="error" class="container">
    <h1><?php echo isset($message)?$message:'404, Page not found'?></h1>
    <p>The Page you are looking for doesn't exist or an other error occurred.</p>
    <a class="btn btn-success" href="<?php site_url()?>">GO BACK TO THE HOMEPAGE</a>
</section>
<style>
    #error h1{ font-size: 50px;}
    #error p{
        color:red;
        text-align: center;
    }
</style>
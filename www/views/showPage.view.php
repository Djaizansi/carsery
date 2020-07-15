
<?php

use carsery\core\Helpers;
use carsery\core\Session;
use carsery\core\View;
use carsery\Managers\ArticleManager;
use carsery\Managers\CategoryManager;
use carsery\Managers\ShortCodeManager;
use carsery\Managers\UserManager;
?>

<?php if(isset($_SESSION['reussite']) && $_SESSION['reussite'] == "resolvearticle"):?>
    <?= Helpers::alert('success','',"L'article a été résolu") ?>
<?php elseif(isset($_SESSION['reussite']) && $_SESSION['reussite'] == "updatearticle"): ?>
    <?= Helpers::alert('success','',"L'article a bien été modifié") ?>
<?php elseif(isset($_SESSION['reussite']) && $_SESSION['reussite'] == "addarticle"): ?>
    <?= Helpers::alert('success','',"L'article a bien été ajouté") ?>
<?php elseif(isset($_SESSION['reussite']) && $_SESSION['reussite'] == "deletemessage"): ?>
    <?= Helpers::alert('success','',"Le message a bien été supprimé") ?>
<?php else: ?>

<?php endif ?>
<?php unset($_SESSION['reussite']) ?>

<?php
$content = $found->getContent();

    $findAll = $shortCodeManager->findAll();
    $shortCodeWrited =false;
    foreach($findAll as $key => $unShort){
        $images = $unShort->getImages();
        /* $type = $Unshort->getType(); */
        $internalTab = explode(',',$images);
        $shortcode = $unShort->getShortcode();
        $sizeShortCode = strlen($shortcode);
        $verifCode = View::checkShortcode($content);

        $found = false;
        foreach($verifCode as $unCode){
            if($unCode == $shortcode){
                $found = true;
            }
        }
        
        if($found && $unShort->getType() == "caroussel"){
            $shortCodeWrited = true;
            $index = stripos($content,$shortcode, 0);
            $pre = substr($content,0,$index);
            $post = substr($content,$index+$sizeShortCode);
            //if ($key < count($findAll) - 1){
                echo $pre;
            //}
            
            $data = [
                'listOfPictures' => $internalTab 
            ];

            $this->addModal('carousel',$data);
            //if ($key == count($findAll) - 1){
                echo $post;
            //}
        }elseif($found && $unShort->getType() == "forum"){
            $shortCodeWrited = true;
            $index = stripos($content,$shortcode, 0);
            $pre = substr($content,0,$index);
            $post = substr($content,$index+$sizeShortCode);
            //if ($key < count($findAll) - 1){
            echo $pre;
            //}
            $data = [];

            $articleManager = new ArticleManager();
            $categoryManager = new CategoryManager();
            $userManager = new UserManager();

            $articles = $articleManager->findAll();
            $categories = $categoryManager->findAll();

            $cats = [];
            foreach ($categories as $category) {
                foreach ($articles as $article) {
                    if ($article->getCategory()->getId() == $category->getId()) {
                        if (isset($cats[$category->getName()])) {
                            $cats[$category->getName()] = array_merge($cats[$category->getName()], array($article));
                        } else {
                            $cats[$category->getName()] = array($article);
                        }
                    }
                }
            }

            $data['categories'] = $cats;
            $configAddArticle = $articleManager->getArticleForm();
            $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();
            $data['configAddArticle'] = $configAddArticle;

            if (Session::estConnecte()) {
                $user = $userManager->find($_SESSION['id']);
                $data['user'] = $user;
                $this->addModal('article',$data);
            } else {
                echo "bjr";
            }

            //if ($key == count($findAll) - 1){
            echo $post;
            //}
        }
    }

    if($shortCodeWrited == false){
        echo $content;
    }
    




?>
<script>
    $(".addslash").each(function(){
        var image = $(this).attr("src");
        var final = $(this).attr("src",'/'+image);
        console.log(final);
    });
</script>
<?php  
//Tab Shortcode content 
//Parcourir ce tableau
//Search tableau page if [carousel] ou [carousel2]....
//Replace


/* $shortCodeManager = new ShortCodeManager();
$findAllShort = $shortCodeManager->findAll();

echo '<pre>'; */
/* $verifCode = View::checkShortcode($content); */
/* $content = 'Bonjour ca va ? '; */

/* foreach($findAllShort as $unShortcode){
    foreach($verifCode as $short){
        if($short == $unShortcode->getShortcode()){
            $unTab[] = $short;
        }
    }
} */

/* $findCode = $shortCodeManager->findByCode($unTab[0]);
foreach($findAllShort as $unshort)
if($unTab[0] == $unshort->getShortcode()){
    echo preg_replace('/\[[^]]*\]/i',$findCode->getContent(),$content);
} */

/* $findAllCode = $shortCodeManager->findAll();

$verifCode = View::useShortcode($content);
var_dump($verifCode);
foreach($findAllCode as $shortCode)
{
    $tab[]=$shortCode->getContent();
}

echo preg_replace($verifCode,$tab,$content); */

/* 

foreach($verifCode as $code){
    $findCode = $shortCodeManager->findByCode($code)->getShortcode();
    $contentShort = $shortCodeManager->findByCode($code)->getContent(); 
    
    if($findCode == $code){
        eval($contentShort);
    }
} 

foreach($verifCode as $short){
    $findCode = $shortCodeManager->findByCode($short);
    echo preg_replace('/\[[^]]*\]/',$findCode->getContent(),$content);
} */

    /* $short = $unShortCode->getShortcode();
    $sizeShortCode = strlen($short);
    $shortContent = $unShortCode->getContent();
    if(stripos($content,$short,0)>=0){
        $index = stripos($content,$short, 0);
        $pre = substr($content,0,$index);
        $post = substr($content,$index+$sizeShortCode);
        
        echo $pre;
        eval($shortContent);
        echo $post;
    } */
?>

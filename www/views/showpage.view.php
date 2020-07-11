
<?php 
    use carsery\core\View;
    use carsery\Managers\ShortCodeManager;

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
        
        if($found){
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

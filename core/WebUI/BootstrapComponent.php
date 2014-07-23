<?php

class WebUI_BootstrapComponent {
    
    public static function Jumbotron($title,$content){
        
        return '<div class="jumbotron">
                    <h1>'.$title.'</h1>
                    <p>'.$content.'</p>
                </div>';
        
    }
    
    public static function ListGroup($items){
        
        $listgroup = '<div class="list-group">';
        
        foreach($items as $key => $value){
            $listgroup .= '<a href="#/'.$key.'" class="list-group-item">'.$value.'</a>';
        }
        
        return $listgroup .'</div>';
        
    }
    
    
    public static function ListGroupPanel($items){
        
        $listgroup = '<div class="list-group">';
        
        foreach($items as $item){
            $listgroup .= '<a href="#/'.$item['link'].'" class="list-group-item">
                            <h4 class="list-group-item-heading">'.$item['title'].'</h4>
                            <p class="list-group-item-text">'.$item['content'].'</p>
                          </a>';
        }
        
        return $listgroup .'</div>';
        
    }
    
}
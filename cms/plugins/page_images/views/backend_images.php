<?php if (!defined('CMS_ROOT')) die; ?>





      <ul id="PIList" style="
    padding: 5px;
    margin-bottom: -10px;
"><li>
        
         <div id="PIPlugin" rel="<?php echo $page_id; ?>" class="plugin">
	
	
	<button style="
    width: 80px;
    height: 80px;
    /* background: #22313a; */
    border-radius: 4px;
       
           
" id="PIAddButton"  class="button-image button-add-style" role="button"><i class="zmdi zmdi-plus"></i> 
        
        
        
        </button>
        
  
        
</div>     
              
              
              
              
          </li>
		<?php foreach( $images as $item ): ?>
		<li  rel="<?php echo $item->id; ?>">
			<img class="pi-image" src="<?php echo $item->url(80, 80); ?>" alt="<?php echo $item->file_name; ?>" title="<?php echo $item->file_name; ?>" />
			<a  class="pi-remove-link  pager-inage-style" href="<?php echo get_url('plugin/page_images/delete/' . $item->id); ?>" title="<?php echo __('Remove'); ?>"><i class="zmdi zmdi-close"></i></a>
		</li>
		<?php endforeach; ?>
	</ul>
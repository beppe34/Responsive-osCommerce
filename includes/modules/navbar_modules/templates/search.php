<li class="col-sm3">
   <!-- a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php //  echo MODULE_NAVBAR_SEARCH; ?></a -->
  <?php
  
    $content_width = MODULE_CONTENT_HEADER_SEARCH_CONTENT_WIDTH;

    $search_box = '<div class="searchbox-margin">';
    $search_box .= tep_draw_form('quick_find', tep_href_link('advanced_search_result.php', '', $request_type, false), 'get', 'class="form-horizontal"');
    $search_box .= '  <div class="input-group">' .
            '<input type="search" name="keywords" placeholder="Search" class="form-control" style="width:75%"><span class=""><button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button></span>' .
                   '  </div>';
    $search_box .=  tep_hide_session_id() . '</form>';
    $search_box .= '</div>';
    
    echo $search_box;
  ?>
</li>

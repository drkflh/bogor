<!--Category slider-->
<?php
$categories = \App\Models\Reference\ProductCategory::get();
$cat = \App\Helpers\CmsUtil::getCategoryBySlug('campaign-list');
$aux = [
    'head'=>'',
    'title'=>($cat['categoryName'] ?? ''),
    'description'=>($cat['categoryDescription'] ?? '')
];
?>
{!! \App\Helpers\CmsUtil::singleBlock( $categories, 'category_slider', 'nest_frontend', $aux ) !!}

<!--End category slider-->

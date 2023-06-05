<img class="card-img-top" src="" alt="Card image cap"
     onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/blank.png' ) ) }}';"
>
<div class="card-body">
    <h5 class="card-title">@{{ item.campaignTitle }}</h5>
    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
    <p class="card-text"><small class="text-muted">Updated @{{ item.updatedAt }}</small></p>
    <button class="btn btn-primary add" @click="addToCart(item)" ><i class="la las-shopping-cart mr-5"></i>Add </button>

</div>

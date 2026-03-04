<a href="{{isset($link)?$link:"#"}}" class="col-xl-2 col-md-4 col-sm-6">
    <div class="card text-center">
        <div class="card-content">
            <div class="card-body">
                <div class="avatar bg-rgba-{{$color}} p-50 m-0 mb-1">
                    <div class="avatar-content">
                        <i class="feather icon-shopping-cart text-{{$color}} font-medium-5"></i>
                    </div>
                </div>
                <h2 class="text-bold-700">{{$value}}</h2>
                <p class="mb-0 line-ellipsis" style="color: #6e6a6a">{{$title}}</p>
            </div>
        </div>
    </div>
</a>

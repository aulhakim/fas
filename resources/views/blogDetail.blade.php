@include('layouts.header')

    <div class="row">
        <div class="col-md-8">
          <span class="pb-4 mb-4 fst-italic border-bottom">
            <img src="{{asset('assets/image/blog/'.$data->image.'')}}" class="img-fluid" alt="..." style="width:100%; height:380px" >
          </span>
    
          <article class="blog-post">
            <h2 class="blog-post-title">{{$data->title}}</h2>
            <p class="blog-post-meta"><?= date('d F Y', strtotime($data->created_at)) ?> by <a href="#">{{$data->creater }}</a></p>
    
            {!!$data->content!!}
          </article><!-- /.blog-post -->
    
        </div>
        <div class="col-md-4">
        
    
          <div class="p-4 mb-3  bg-light rounded">
            <h4 class="fst-italic">Newest</h4>
            <ol class="list-unstyled mb-0">
                @foreach($newest as $key => $value)
                <li><a href="{{url('blog/'.$value->slug.'')}}">{{$value->title}}</a></li>
            @endforeach

              
            </ol>
          </div>
    
          <div class="p-4 bg-light rounded">
            <h4 class="fst-italic">Me</h4>
            <ol class="list-unstyled">
              <li><a target="blank__" href="https://github.com/aulhakim">GitHub</a></li>
              <li><a target="blank__" href="https://www.linkedin.com/in/aulia-rachman-hakim/">Linkedin</a></li>
              <li><a target="blank__" href="https://twitter.com/mylasthoughts">Twitter</a></li>
            </ol>
          </div>
        </div>
    
      </div><!-- /.row -->
    </div>
    @include('layouts.footer')

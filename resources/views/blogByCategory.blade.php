@include('layouts.header')

      <div class="row mb-2">

        @if(!empty($data) && $data->count())
            @foreach($data as $key => $value)
            <div class="col-md-6">
                <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                  <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-primary">{{$value->category}}</strong>
                    <h3 class="mb-0">{{$value->title}}</h3>
                    <div class="mb-1 text-muted"><?= date('d F Y', strtotime($value->created_at)) ?></div>
                    <p class="card-text mb-auto">{!!$value->content!!}</p>
                    <a href="{{url('blog/'.$value->slug.'')}}" class="stretched-link">Continue reading</a>
                  </div>
                  <div class="col-auto d-none d-lg-block">
                  
                    <img src="{{asset('assets/image/blog_thumb/'.$value->image.'')}}" alt="" width="200" height="250">
          
                  </div>
                </div>
              </div>
            @endforeach
          @else
             <p>There are no data.</p>
          @endif

        
      </div>
      
    {!! $data->links() !!}

    @include('layouts.footer')

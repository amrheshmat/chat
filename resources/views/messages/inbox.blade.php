@extends('layouts.app')
<style>
.message{
    padding-left: 4px;
    background-color: #161c3861;;
    display: block;
    word-break: break-all;
    padding: 3px;
    border-radius: 5px;
    top: 10px;
    margin-left: 2px;
    margin-top: 3px;color: #fff;font-weight: bold;
}
</style>
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body row">
            <!-- Card stats -->
            @if($income_messages)

                @foreach($income_messages as $income_message)
                <div id="display" class="col-lg-3" style="display: inline;background-color: #fff; padding: 20px 10px; border-radius: 5px;   margin-right: 5px;margin-left: 15px;margin-bottom: 10px;">
                  <!-- {{$income_message->message_from}} -->

                 <a  href=""  class="{{$income_message->message_from}}" > Unknown </a>

                  <i class="fab fa-facebook-messenger" style="color: #f4645f;">{{$income_message->count}}</i>
                  <div class='prev {{$income_message->message_from}}' style="display:none; border-top-left-radius:9px;border-top-right-radius:9px;  position: fixed; bottom: 2px; background: rgba(84, 99, 121, 0.5);width: 279px; min-height: 300px; margin-left: 17px;">
                <span   style="border-top-left-radius:7px;border-top-right-radius:7px;width: 100%; background-color: #232b58d9; display: inline-block;padding-left: 7px;font-weight: bold;color: #fff; margin-bottom: 7px;">Unknown</span>
                <form class="f" method="post" action="{{ route('messages.replymessage') }}" autocomplete="off">
                            @csrf 
                            @method('put')
                        <input class="col-lg-7" type="hidden" name="name" id="input-email" class="form-control form-control-alternative" value="{{$income_message->message_to}}" required>     
                       <div style="position: absolute;bottom: 1px;">
                            <input type="text" name="message_content">
                            <input type="submit" class=" ">
                        </div>
                </form>
            </div>
            
                </div>
                

                @endforeach
            @endif
        </div>
    </div>
</div>



@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>


$(document).ready(function() {
      $('#display a').click(function() {

        $class = '.'+$(this).attr("class");
    //alert($class);
   $('.prev').css('display','none');
$($class).css('display','block');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

               //var id =$(this).attr("class");
               // alert(id);
        
          
               $.ajax({
             type:"POST",
             url:"/calc_list2/",
             data: { id: $('#display a').attr("class") },
             success : function(results) {
            var data = results.surrey;
           
           
            $('.message').remove();
    
              results.forEach(function(item) {
                  var $sent_to = 'div.'+item["message_from"] +" " +".f";
                var $data =  $($sent_to);
                //console.log($sent_to);
                var $message = $('<p class="message"></p>');
               // $data.append($message);
                    // iterate through all the properties of current JSON object
                    $message.append(item["message_content"]);
                    $data.before($message);
                    //
                    console.log($data);
                   //console.log(item["message_content"]);
                    });
                    
             }
        });
       // console.log($(this).attr("class"));
        return false; //to prevent load 
    });
});
</script>
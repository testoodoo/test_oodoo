<script src="/assets/dist/admin/js/sonic.js"></script>
<script type="text/javascript">
var circle = new Sonic({
    width: 15,
    height: 15,
    padding: 5,
    strokeColor: '#000',
    pointDistance: .01,
    stepsPerFrame: 3,
    trailLength: .7,
    step: 'fader',
    setup: function() {
      this._.lineWidth = 2;
    },
    path: [
        ['arc', 8, 8, 8, 0, 360]
    ]
});


function activation() {
  
  var type = $('#crf').val();
  var type2 = $('#val2').val();


  $('#valnam').hide();
  $('#valnamd').hide();
  $('#valnam2').hide();
  $('#valna').hide();


  $('#buthid').hide();
  $('#buthid1').hide();
  $('#buthid2').hide();
  document.getElementById('cir_dev').appendChild(circle.canvas);
  circle.play();

                    if (type.length != 0) {
                      $.ajax({
                            url:'/admin/planActivation',
                            type:'POST',
                            data:type,
                            dataType:'json',
                            success: function( json ) {
                               $(".sonic").remove();
                               $("#cir_dev").attr({class:'fa fa-check fa-2x', style:"color:green"});
                                document.getElementById("acct").innerHTML ="ACCOUNT CREATED";
                                document.getElementById("val").innerHTML =type;
                                $('#valnam').show();
                               var types = $('#vale').val();
                               creation(types);
                               },
                            error: function() {
                               $(".sonic").remove();
                               $("#cir_dev").attr({class:'fa fa-close fa-2x', style:"color:red"});
                               $('#buthid').show();
                               }
                            }
                        )};
                    }
                    function creation(types){
                      
                           document.getElementById('cir_dri').appendChild(circle.canvas);
                             circle.play();

                    if (types.length != 0) {
                      $.ajax({
                            url:'/admin/planActivation',
                            type:'POST',
                            data:types,
                            dataType:'json',
                            success: function( json ) {
                               $(".sonic").remove();
                               $("#cir_dri").attr({class:'fa fa-check fa-2x', style:"color:green"});
                                document.getElementById("acca").innerHTML ="ACCOUNT ACTIVATED";
                                 $('#valnamd').show();
                                document.getElementById("one").innerHTML = types;
                                 $('#valna').show();
                              var typet = $('#val2').val();
                               subscribe(typet);
                               },
                            error: function() {
                               $(".sonic").remove();
                               $("#cir_dri").attr({class:'fa fa-close fa-2x', style:"color:red"});
                               $('#buthid1').show();
                               }
                            }
                        )};
                    }
                    function subscribe(typet){
                      
                           document.getElementById('cir_de').appendChild(circle.canvas);
                             circle.play();
                        if (typet.length != 0) {
                      $.ajax({
                            url:'/admin/planActivation',
                            type:'POST',
                            data:typet,
                            dataType:'json',
                            success: function( json ) {
                               $(".sonic").remove();
                               $("#cir_de").attr({class:'fa fa-check fa-2x', style:"color:green"});
                                document.getElementById("accs").innerHTML ="SUBSCRIBE ACTIVATED";
                                document.getElementById("two").innerHTML =typet;
                                $('#valnam2').show();

                               },
                            error: function() {
                               $(".sonic").remove();
                               $("#cir_de").attr({class:'fa fa-close fa-2x', style:"color:red"});
                               $('#buthid2').show();
                               }
                            }
                        )}; 
                    }

                
</script>

<script type="text/javascript">

$( document ).ready(function() {
  activation();
});
</script>
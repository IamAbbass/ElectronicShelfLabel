<?php 
  
  require_once('dbconfig.php');
  require_once('function.php');


  $tableName = 'add_product';

  $getData = get($tableName);



 ?>

<!DOCTYPE html>
<html lang="en">


<?php 
  include "header.php";
 ?>


<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <?php 
      include "sidebar.php";
     ?>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="navbar-toggler-icon btn btn-default" id="menu-toggle"></button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>

      <div class="container-fluid">
        <div class="text-center heading-container">
          <h1 class="heading">ESL</h1>
        </div>
        <div class="container">
          
          
          <canvas width="296" height="128" style="border: 2px solid #eee;"></canvas>
          <div class="row">
            <div class="col-md-12">
              <div id="mqtt_status" class="alert mb-10"></div>
            </div>
            <div class="col-sm-6">
              <div style="margin-top: 10px;margin-bottom: 10px;">
                <!-- <img src="images/qr.png" id="pic" width="20" height="20" style="border: 1px solid darkgrey;"> -->
                <img id="barcode"/>
                <div id="pic"></div>
                <img src="" id="barImage"> 
                
                <div id="image1"></div>
                <ul class="list-group" style="margin-top: 10px;">
                  <div class="form-inline mb-2">
                    <!-- <label for="">State</label> -->
                    <select id="p_name" class="form-control col-md-8" >
                      <option selected disabled="">Choose...</option>
                    <?php 
                      foreach ($getData as $key => $value) {
                     ?>
                      <option value="<?=$value['id']?>"><?=$value['name']?></option>
                    <?php 
                      }
                     ?>
                    </select>
                    <button type="button" class="btn btn-primary col-md-4 btn_update_1">Submit</button>
                  </div>
                  <li class="list-group-item d-flex justify-content-between align-items-center">GMAC : <span class="gmac"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center" >MAC :  <span class="mac1"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">RSSI : <span class="rssi1"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Capability : <span class="cap1"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Label Type : <span class="label1"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Battery Voltage : <span class="volt1"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Signal Power : <span class="signal1"></span></li>
                  <!-- <li class="list-group-item d-flex justify-content-between align-items-center">PIC ID : <span class="pic_id1"></span></li> -->
                  <li class="list-group-item d-flex justify-content-between align-items-center">Status : <span class="status1"></span></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-6">
              <div style="margin-top: 10px;margin-bottom: 10px;">
                <img id="barcode2"/>
                <div id="pic2"></div>
                <img src="" id="barImage2"> 

                <div id="image2"></div>
                <!-- <img src="" class="img-fluid col-lg-12 " style="border: 1px solid darkgrey;"> -->

                <ul class="list-group" style="margin-top: 10px;">
                  <div class="form-inline mb-2">
                    <!-- <label for="">State</label> -->
                    <select id="name" class="form-control col-md-8">
                      <option selected disabled="">Choose...</option>
                    <?php 
                      foreach ($getData as $key => $value) {
                     ?>
                      <option value="<?=$value['id']?>"><?=$value['name']?></option>
                    <?php 
                      }
                     ?>
                    </select>
                    <button type="button" class="btn btn-primary col-md-4 btn_update_2">Submit</button>
                  </div>
                  <li class="list-group-item d-flex justify-content-between align-items-center">GMAC : <span class="gmac"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center" >MAC :  <span class="mac2"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">RSSI : <span class="rssi2"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Capability : <span class="cap2"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Label Type : <span class="label2"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Battery Voltage : <span class="volt2"></span></li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Signal Power : <span class="signal2"></span></li>
            
                  <li class="list-group-item d-flex justify-content-between align-items-center">Status : <span class="status2"></span></li>
                </ul>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="vendor/js/jquery.qrcode.min.js"></script>
  <script src="vendor/js/mqttws31.min.js"></script>
  <script type="text/javascript" src="vendor/js/JsBarcode.all.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $('canvas').hide();
    $('#pic').hide();
    $('#barcode').hide();
    $('#barImage').hide();
    $('#pic2').hide();
    $('#barcode2').hide();
    $('#barImage2').hide();

    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    client = new Paho.MQTT.Client("m24.cloudmqtt.com", 35040,"myclientid_" + parseInt(Math.random() * 100, 10));
    console.log(client);
      client.onConnectionLost = onConnectionLost;
      client.onMessageArrived = onMessageArrived;
      var options = {
         useSSL: true,
         userName: "rrxuzwyb",
         password: "30dq8_Wj-USm",
         onSuccess:onConnect,
         onFailure:doFail
      }
      client.connect(options);
      $("#mqtt_status").removeClass("alert-danger").addClass("alert-success")
        .html("MQTT Connecting").hide().show();

      function onConnect() {
        client.subscribe("esl/status");
        client.subscribe("esl/reply");
        client.subscribe("esl/command");

        $("#mqtt_status").removeClass("alert-danger").addClass("alert-success")
        .html("MQTT Connected!").hide().show();
        $('.status1').addClass("badge badge-success").removeClass("badge-danger")
            .html('Connected').hide().show();
        $('.status2').addClass("badge badge-success").removeClass("badge-danger")
            .html('Connected').hide().show();
        // setInterval(function(){$("#mqtt_status").fadeOut(); }, 2000);
      }
      function doFail(e){
        console.log(e);
        $("#mqtt_status").removeClass("alert-success").addClass("alert-danger")
        .html("Request Failed!").hide().show();
        // setTimeout(function(){$("#mqtt_status").fadeOut(); }, 10000);
         client.connect(options);
      }

      function onConnectionLost(responseObject) {
        console.log(responseObject);
        if (responseObject.errorCode !== '0' || responseObject.errorCode !== '1') {          
          $("#mqtt_status").removeClass("alert-success").addClass("alert-danger")
              .html("MQTT Disconnected!").hide().show();
          $('.status1').addClass("badge badge-danger").removeClass("badge-success")
            .html('Disconnected').hide().show();
          $('.status2').addClass("badge badge-danger").removeClass("badge-success")
            .html('Disconnected').hide().show();
            client.connect(options);
            // setTimeout(function(){$("#mqtt_status").fadeOut(); }, 10000);
        }
      }
            // called when a message arrives
      function onMessageArrived(message) {
        var topic = message.destinationName; 
        var msg   = message.payloadString; 
        console.log(msg);
        if(topic == "esl/reply"){
          $("#mqtt_status").removeClass("alert-danger").addClass("alert-success")
                .html("ESL Updated!").hide().show();
        }else if(topic == "esl/status"){
          var data  = JSON.parse(msg);
            console.log(data);
            $(".gmac").html(data.gmac);

          try{
            $value = data.obj[0].data1;
            $val   = $value.length;
            var signalPower = $value.substr($val-2, 2);
            var batteryVol  = $value.substr($val-18, 4);
            var capability  = $value.substr($val-22, 2);
            var labelType   = $value.substr($val-20, 2);
            if (labelType == "00") {
              $('.label1').html('2.9" Two colors');
            }else if(labelType == "01"){
              $('.label1').html('2.9" Three colors');
            }
            else if(labelType == "02"){
             $('.label1').html('4.2" Two colors'); 
            }
            else if(labelType == "03"){
             $('.label1').html('4.2" Three colors'); 
            }
            $('.cap1').html(capability);

            $('.signal1').html(signalPower);
            $('.volt1').html(batteryVol);
            $(".mac1").html(data.obj[0].dmac);
            $('.status1').addClass("badge badge-success").removeClass("badge-danger")
            .html('Connected').fadeIn();
          }catch(e){
            $('.status1').addClass("badge badge-danger").removeClass("badge-success")
            .html('Disconnected').hide().fadeIn();
          }

          try{
            $value = data.obj[1].data1;
            $val   = $value.length;
            var signalPower = $value.substr($val-2, 2);
            var batteryVol  = $value.substr($val-18, 4);
            var capability  = $value.substr($val-22, 2);
            var labelType   = $value.substr($val-20, 2);

            $('.signal2').html(signalPower);
            $('.volt2').html(batteryVol);

            if (labelType == "00") {
              $('.label2').html('2.9" Two colors');
            }else if(labelType == "01"){
              $('.label2').html('2.9" Three colors');
            }
            else if(labelType == "02"){
             $('.label2').html('4.2" Two colors'); 
            }
            else if(labelType == "03"){
             $('.label2').html('4.2" Three colors'); 
            }
            $('.cap2').html(capability);
            $(".mac2").html(data.obj[1].dmac);
            $('.status2').addClass("badge badge-success").removeClass("badge-danger")
            .html('Connected').fadeIn();
          }catch(e){
            $('.status2').addClass("badge badge-danger").removeClass("badge-success")
            .html('Disconnected').hide().fadeIn();
          }

            try{$(".rssi1").html(data.obj[0].rssi);}catch(e){}
            try{$(".rssi2").html(data.obj[1].rssi);}catch(e){}  
            try{$(".rssi1").html(data.obj[0].rssi);}catch(e){}
            try{$(".rssi2").html(data.obj[1].rssi);}catch(e){} 
        }else if(topic == "esl/command"){
          $("#mqtt_status").removeClass("alert-danger").addClass("alert-success")
                .html("MQTT Command Sent!").hide().fadeIn();
        }
      }

      $(".btn_update_1").click(function(){
     
        localStorage.removeItem('picture');
        $mac1 = $('.mac1').html();
        $id   = $("#p_name :selected").attr('value');
        JsBarcode("#barcode", $id, {
          width:1,
          height:40,
          displayValue:false,
        });

        jQuery(function(){
          $('#pic').qrcode($mac1);
          var canv = $('#pic canvas');
          var img = canv.get(0).toDataURL("image/png");
          $('#barImage').attr('src',img);
        });

        
        $.get('product.php?action=update&id='+$id+"&esl_mac="+$mac1,function(data){
          console.log(data);
          $data        = JSON.parse(data);
          $name        = $data.name;
          $price       = $data.price;
          $discount    = $data.discount;
          $date        = $data.expiry_date;

          if ($data !== '') {
            var CanvasToBMP = {
              toArrayBuffer: function(canvas) {

                var w = canvas.width,
                    h = canvas.height,
                    w4 = w * 4,
                    idata = canvas.getContext("2d").getImageData(0, 0, w, h),
                    data32 = new Uint32Array(idata.data.buffer), // 32-bit representation of canvas
                    stride = Math.floor((32 * w + 31) / 32) * 4, // row length incl. padding
                    pixelArraySize = stride * h,                 // total bitmap size
                    fileLength = 122 + pixelArraySize,           // header size is known + bitmap

                    file = new ArrayBuffer(fileLength),          // raw byte buffer (returned)
                    view = new DataView(file),                   // handle endian, reg. width etc.
                    pos = 0, x, y = 0, p, s = 0, a, v;
                // write file header
                setU16(0x4d42);          // BM
                setU32(fileLength);      // total length
                pos += 4;                // skip unused fields
                setU32(0x7a);            // offset to pixels

                // DIB header
                setU32(108);             // header size
                setU32(w);
                setU32(-h >>> 0);        // negative = top-to-bottom
                setU16(1);               // 1 plane
                setU16(32);              // 32-bits (RGBA)
                setU32(3);               // no compression (BI_BITFIELDS, 3)
                setU32(pixelArraySize);  // bitmap size incl. padding (stride x height)
                setU32(2835);            // pixels/meter h (~72 DPI x 39.3701 inch/m)
                setU32(2835);            // pixels/meter v
                pos += 8;                // skip color/important colors
                setU32(0xff0000);        // red channel mask
                setU32(0xff00);          // green channel mask
                setU32(0xff);            // blue channel mask
                setU32(0xff000000);      // alpha channel mask
                setU32(0x57696e20);      // " win" color space
                // bitmap data, change order of ABGR to BGRA
                while (y < h) {
                  p = 0x7a + y * stride; // offset + stride x height
                  x = 0;
                  while (x < w4) {
                    v = data32[s++];                     // get ABGR
                    a = v >>> 24;                        // alpha channel
                    view.setUint32(p + x, (v << 8) | a); // set BGRA
                    x += 4;
                  }
                  y++
                }
                return file;
                function setU16(data) {view.setUint16(pos, data, true); pos += 2}
                function setU32(data) {view.setUint32(pos, data, true); pos += 4}
              },
              toBlob: function(canvas) {
                return new Blob([this.toArrayBuffer(canvas)], {
                  type: "image/bmp"
                });
              },
              toDataURL: function(canvas) {
                var buffer = new Uint8Array(this.toArrayBuffer(canvas)),
                    bs = "", i = 0, l = buffer.length;
                while (i < l) bs += String.fromCharCode(buffer[i++]);
                return "data:image/bmp;base64," + btoa(bs);
              }
            };

            var canvas = document.querySelector("canvas"),
              w = canvas.width,
              h = canvas.height,
              ctx = canvas.getContext("2d"),
              
            img = new Image();
            var imge    = document.getElementById("barImage");
            var barcode = document.getElementById("barcode");

            // console.log(barcode.src);
            ctx.font = "25px Arial";
            ctx.fillText($name,4,25);
            //RHS
            // ctx.fillText("Scan",220,25);
            // Qrcode
            ctx.drawImage(imge,190,10,102,110);
            // End RHS
            ctx.font = "16px Arial";
            ctx.fillText("Rs:"+$price+" (-"+$discount+"%)",4,50);
            ctx.font = "15px Arial";
            ctx.fillText("Expiry Date : "+$date,4,68);
            // Barcode
            ctx.drawImage(barcode,-10,75,200,50);
            img.src = CanvasToBMP.toDataURL(canvas);
            img.id = $id;
            var test_ = img.src.replace(/^data:image\/(bmp|jpg|jpeg);base64,/, "");
            
            // var tes = String(test_);
            // function base64ToBase16(base64) {
            //   return window.atob(base64)
            //       .split('')
            //       .map(function (aChar) {
            //         return ('0' + aChar.charCodeAt(0).toString(16)).slice(-2);
            //       })
            //      .join('')
            //      .toUpperCase(); // Per your example output
            // }
            //console.log(test_);

            //console.log(base64ToBase16(tes));
            localStorage.setItem("picture",img.src);
                        
            var element = document.getElementById('image1').appendChild(img);
            element.classList.add("img-fluid");

           ctx.clearRect(0, 0,  canvas.width, canvas.height);
          }

        });
          $('#image1').empty();
        // var msg = '{"msg":"dData","mac":"3027010A33DD","seq":4,"auth1":"00000000","dType":"hex","data":"'+txt+'"}';
        // message = new Paho.MQTT.Message(msg);
        // message.destinationName = "esl/command";

        // client.send(message);
       });
      if (localStorage.getItem('picture') !== null ) {
        img = new Image();
      document.getElementById('image1').appendChild(img)
        .setAttribute(
        'src', localStorage.getItem("picture")
        );
      } else {
        img = new Image();
         document.getElementById('image1').appendChild(img)
          .setAttribute(
          'src', "images/pic.bmp"
        );
      }
       
        


      $(".btn_update_2").click(function(){
        localStorage.removeItem('picture2');
        $mac2 = $('.mac2').html();
        $id   = $("#name :selected").attr('value');

        JsBarcode("#barcode2", $id, {
          width:1,
          height:40,
          displayValue:false,
        });

        jQuery(function(){
          $('#pic2').qrcode($mac2);
          var canv = $('#pic2 canvas');
          var img = canv.get(0).toDataURL("image/png");
          $('#barImage2').attr('src',img);
        });

        $.get('product.php?action=update&id='+$id+"&esl_mac="+$mac2,function(data){  
          console.log(data);
          $data        = JSON.parse(data);
          $name        = $data.name;
          $price       = $data.price;
          $discount    = $data.discount;
          $date        = $data.expiry_date;

          if ($data !== '') {
            var CanvasToBMP = {
              toArrayBuffer: function(canvas) {

                var w = canvas.width,
                    h = canvas.height,
                    w4 = w * 4,
                    idata = canvas.getContext("2d").getImageData(0, 0, w, h),
                    data32 = new Uint32Array(idata.data.buffer), // 32-bit representation of canvas
                    stride = Math.floor((32 * w + 31) / 32) * 4, // row length incl. padding
                    pixelArraySize = stride * h,                 // total bitmap size
                    fileLength = 122 + pixelArraySize,           // header size is known + bitmap

                    file = new ArrayBuffer(fileLength),          // raw byte buffer (returned)
                    view = new DataView(file),                   // handle endian, reg. width etc.
                    pos = 0, x, y = 0, p, s = 0, a, v;
                // write file header
                setU16(0x4d42);          // BM
                setU32(fileLength);      // total length
                pos += 4;                // skip unused fields
                setU32(0x7a);            // offset to pixels

                // DIB header
                setU32(108);             // header size
                setU32(w);
                setU32(-h >>> 0);        // negative = top-to-bottom
                setU16(1);               // 1 plane
                setU16(32);              // 32-bits (RGBA)
                setU32(3);               // no compression (BI_BITFIELDS, 3)
                setU32(pixelArraySize);  // bitmap size incl. padding (stride x height)
                setU32(2835);            // pixels/meter h (~72 DPI x 39.3701 inch/m)
                setU32(2835);            // pixels/meter v
                pos += 8;                // skip color/important colors
                setU32(0xff0000);        // red channel mask
                setU32(0xff00);          // green channel mask
                setU32(0xff);            // blue channel mask
                setU32(0xff000000);      // alpha channel mask
                setU32(0x57696e20);      // " win" color space
                // bitmap data, change order of ABGR to BGRA
                while (y < h) {
                  p = 0x7a + y * stride; // offset + stride x height
                  x = 0;
                  while (x < w4) {
                    v = data32[s++];                     // get ABGR
                    a = v >>> 24;                        // alpha channel
                    view.setUint32(p + x, (v << 8) | a); // set BGRA
                    x += 4;
                  }
                  y++
                }
                return file;
                function setU16(data) {view.setUint16(pos, data, true); pos += 2}
                function setU32(data) {view.setUint32(pos, data, true); pos += 4}
              },
              toBlob: function(canvas) {
                return new Blob([this.toArrayBuffer(canvas)], {
                  type: "image/bmp"
                });
              },
              toDataURL: function(canvas) {
                var buffer = new Uint8Array(this.toArrayBuffer(canvas)),
                    bs = "", i = 0, l = buffer.length;
                while (i < l) bs += String.fromCharCode(buffer[i++]);
                return "data:image/bmp;base64," + btoa(bs);
              }
            };

            var canvas = document.querySelector("canvas"),
              w = canvas.width,
              h = canvas.height,
              ctx = canvas.getContext("2d"),
              img = new Image();
              var imge2    = document.getElementById("barImage2");
              var barcode2 = document.getElementById("barcode2");
              ctx.font = "25px Arial";
              ctx.fillText($name,4,25);
              //RHS
              // ctx.fillText("Scan",220,25);
              // Qrcode
              ctx.drawImage(imge2,190,10,102,110);
              
              // End RHS
              ctx.font = "16px Arial";
              ctx.fillText("Rs:"+$price+" (-"+$discount+"%)",4,50);
              ctx.font = "15px Arial";
              ctx.fillText("Expiry Date : "+$date,4,68);
              ctx.drawImage(barcode2,-10,75,200,50);
              // append image from the data-uri returned by the CanvasToBMP code below:
              img.src = CanvasToBMP.toDataURL(canvas);
              img.id  = $id;
               localStorage.setItem("picture2",img.src);
              // console.log(img.src);
              var element = document.getElementById('image2').appendChild(img);
              element.classList.add("img-fluid");
              ctx.clearRect(0, 0,  canvas.width, canvas.height);
              
          }

        });  
            $('#image2').empty();

      });
  
          if (localStorage.getItem('picture2') !== null ) {
            img = new Image();
            document.getElementById('image2').appendChild(img)
              .setAttribute(
              'src', localStorage.getItem("picture2")
            );
          } else {
              img = new Image();
              document.getElementById('image2').appendChild(img)
                .setAttribute(
                'src', "images/pic.bmp"
              );
          }
  </script>

</body>

</html>

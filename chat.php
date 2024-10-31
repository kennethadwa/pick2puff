<?php
include("connect.php");
?>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .wrapper {
            width: 100%;
            max-width: 500px;
            height: 100%;
            max-height: 700px;
            background-color: white;
            color: black;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
        }

        .wrapper .title {
            background: #007bff;
            color: white;
            font-weight: 500;
            line-height: 60px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .wrapper .form {
            flex: 1;
            padding: 20px 15px;
            overflow-y: auto;
        }

        .wrapper .form .user-inbox {
             display: flex;
             justify-content: flex-end; 
             margin: 13px 0;
         }

         .form .user-inbox .msg-header p {
             color: white;
             background: #007bff; 
             border-radius: 10px;
             padding: 8px 10px;
             font-size: 0.9rem;
             word-break: break-word;
             text-align: right; 
         }

        .wrapper .typing-field {
            display: flex;
            height: 60px;
            align-items: center;
            background-color: #efefef;
            border-top: 1px solid #d9d9d9;
            padding: 10px;
        }

        .wrapper .typing-field .input-data {
            flex: 1;
            position: relative;
            height: 40px;
        }

        .wrapper .typing-field .input-data input {
            width: 100%;
            height: 100%;
            padding: 0 80px 0 15px;
            color: black;
            background: white;
            border: 1px solid black;
            border-radius: 3px;
            font-size: 15px;
            outline: none;
        }

        .wrapper .typing-field .input-data button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            height: 30px;
            width: 65px;
            background: #007bff;
            color: white;
            border-radius: 3px;
            cursor: pointer;
            opacity: 0;
            pointer-events: none;
        }

        .wrapper .typing-field .input-data input:valid ~ button {
            opacity: 1;
            pointer-events: auto;
        }

        .form .user-inbox .msg-header p, 
        .form .bot-inbox .msg-header p {
            color: white;
            background: black;
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 0.9rem;
            word-break: break-word;
        }

        .wrapper .form .inbox {
            width: 100%;
            display: flex;
            align-items: baseline;
            margin: 10px 0;
        }

        .wrapper .form .inbox .icon {
            height: 40px;
            width: 40px;
            text-align: center;
            background-color: black;
            color: white;
            line-height: 40px;
            font-size: 1.3rem;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>

<section style="display: flex; justify-content: center; align-items: center;">
  <div class="wrapper" style="width: 100%;">
    <div class="title">Chat Support</div>
    <div class="form">
        <div class="bot-inbox inbox">
            <div class="msg-header">
                <p style="background-color: #007b;">Hello there, how can I help you?</p>
            </div>
        </div>
    </div>
    <div class="typing-field">
        <div class="input-data">
            <input type="text" id="data" placeholder="Do you have any questions?" required>
            <button id="send-btn">Send</button>
        </div>
    </div>
</div>
</section>


<!-- Scripts -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>
<script src="js/dashboard/dashboard-1.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>

<script>
  $(document).ready(function(){
    $("#send-btn").on("click", function(){
         let value = $("#data").val().trim();
         if (value) {
             let msg = '<div class="user-inbox inbox"><div class="msg-header"><p style="background-color: #007bff;">' + value + '</p></div></div>';
             $(".form").append(msg);
             $("#data").val('');
             $.ajax({
                url: 'message.php',
                type: 'POST',
                data: { text: value },
                success: function(result){
                  let reply = '<div class="bot-inbox inbox"><div class="msg-header"><p style="background-color: #007b;">' + result + '</p></div></div>';
                  $(".form").append(reply);
                  $(".form").scrollTop($(".form")[0].scrollHeight);
                }
             });
         }
    });
  });
</script>

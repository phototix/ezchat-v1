<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth-login");
    exit();
}
checkAdminAccess();

$stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$userId = $user['username'];
$apiKey = '8cd0de4e14cd240a97209625af4bdeb0'; // Replace with your actual API key
$qrApiUrl = "https://server01.ezy.chat/api/screenshot?session=".$userId;
$statusApiUrl = "https://server01.ezy.chat/api/sessions/$userId";
?>
<?php include("includes/htmlstart.php"); ?>
<div class="layout-wrapper d-lg-flex">

    <!-- Start left sidebar-menu -->
    <div class="side-menu flex-lg-column">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="/dashboard" class="logo logo-dark">
                <span class="logo-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M8.5,18l3.5,4l3.5-4H19c1.103,0,2-0.897,2-2V4c0-1.103-0.897-2-2-2H5C3.897,2,3,2.897,3,4v12c0,1.103,0.897,2,2,2H8.5z M7,7h10v2H7V7z M7,11h7v2H7V11z"/></svg>
                </span>
            </a>

            <a href="chat.html" class="logo logo-light">
                <span class="logo-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M8.5,18l3.5,4l3.5-4H19c1.103,0,2-0.897,2-2V4c0-1.103-0.897-2-2-2H5C3.897,2,3,2.897,3,4v12c0,1.103,0.897,2,2,2H8.5z M7,7h10v2H7V7z M7,11h7v2H7V11z"/></svg>
                </span>
            </a>
        </div>
        <!-- end navbar-brand-box -->

        <!-- Start side-menu nav -->
        <div class="flex-lg-column my-0 sidemenu-navigation">
            <ul class="nav nav-pills side-menu-nav" role="tablist">

                <?php include("includes/sidemenu.php"); ?>
                
            </ul>
        </div>
        <!-- end side-menu nav -->
    </div>
    <!-- end left sidebar-menu -->

    <!-- Start User chat -->
    <div class="user-chat w-100 overflow-hidden user-chat-show">

        <div class="chat-content d-lg-flex">

            <!-- start chat conversation section -->
            <div class="w-100 overflow-hidden position-relative">

                <div class="qr-code-container p-5">
                    <br><br><br><br>
                    <center>

                    <style>
                        body {
                            font-family: Arial, sans-serif;
                        }
                        #canvas {
                            width: 100%;
                            height: 400px;
                            border: 1px solid #ddd;
                        }
                        textarea {
                            width: 100%;
                            height: 150px;
                            margin-bottom: 10px;
                        }
                        button {
                            padding: 10px;
                            background-color: #4CAF50;
                            color: white;
                            border: none;
                            cursor: pointer;
                        }
                    </style>

                    <h2>Workflow Builder</h2>

                    <!-- Text Area for Inputting Workflow -->
                    <textarea id="workflow-input" placeholder="Enter your workflow definition here..."></textarea>
                    <br>

                    <!-- Button to Render the Workflow -->
                    <button onclick="generateFlowchart()">Generate Workflow</button>

                    <!-- Canvas where the workflow will be rendered -->
                    <div id="canvas"></div>

                    <script>
                        function generateFlowchart() {
                            var input = document.getElementById('workflow-input').value;
                            var canvas = document.getElementById('canvas');

                            // Clear previous flowchart if any
                            canvas.innerHTML = '';

                            // Generate the flowchart
                            try {
                                var chart = flowchart.parse(input);
                                chart.drawSVG('canvas', {
                                    'x': 0,
                                    'y': 0,
                                    'line-width': 2,
                                    'line-length': 50,
                                    'text-margin': 10,
                                    'font-size': 14,
                                    'font-color': 'black',
                                    'line-color': 'black',
                                    'element-color': 'black',
                                    'fill': 'white',
                                    'yes-text': 'yes',
                                    'no-text': 'no',
                                    'arrow-end': 'block',
                                    'scale': 1,
                                    'symbols': {
                                        'start': {
                                            'font-color': 'white',
                                            'element-color': '#4CAF50',
                                            'fill': '#4CAF50'
                                        },
                                        'end': {
                                            'font-color': 'white',
                                            'element-color': '#FF5733',
                                            'fill': '#FF5733'
                                        }
                                    }
                                });
                            } catch (e) {
                                alert("Error in flowchart definition: " + e.message);
                            }
                        }
                    </script>
                    
                    <br><br>
                    <a href="/whatsapp_restart" style="color:red;">Restart Instance</a>
                    </center>
                </div>
                
            </div>
            <!-- end chat conversation section -->

        </div>
        <!-- end user chat content -->
    </div>
    <!-- End User chat -->

</div>
<!-- end  layout wrapper -->
<?php include("includes/javascript.php"); ?>
<!-- CDN for Raphael.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>

<!-- CDN for Flowchart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowchart/1.15.0/flowchart.min.js"></script>
<?php include("includes/htmlend.php"); ?>
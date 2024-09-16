<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth-login");
    exit();
}
checkAdminAccess();

$stmt = $pdo->prepare("SELECT username, workflows FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$userId = $user['username'];
$workflows = $user['workflows'];
if($workflows==""){
    $workflows = '{
  "operators": {
    "operator1": {
      "top": 20,
      "left": 20,
      "properties": {
        "title": "Operator 1",
        "inputs": {},
        "outputs": {
          "output_1": {
            "label": "Output 1"
          }
        }
      }
    },
    "operator2": {
      "top": 80,
      "left": 300,
      "properties": {
        "title": "Operator 2",
        "inputs": {
          "input_1": {
            "label": "Input 1"
          },
          "input_2": {
            "label": "Input 2"
          }
        },
        "outputs": {}
      }
    }
  },
  "links": {
    "link_1": {
      "fromOperator": "operator1",
      "fromConnector": "output_1",
      "toOperator": "operator2",
      "toConnector": "input_2"
    }
  },
  "operatorTypes": {}
}';
}
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

            <!-- Start Content Body Top Header -->
            <div class="p-3 p-lg-4 user-chat-topbar">
                <div class="row align-items-center">
                    <div class="col-sm-4 col-8">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 d-block d-lg-none me-3">
                                <a href="/dashboard" class="user-chat-remove font-size-18 p-1"><i class="bx bx-chevron-left align-middle"></i></a>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex align-items-center">                            
                                    <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                        <img src="/assets/logo.jpg" class="rounded-circle avatar-sm" alt="">
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="text-truncate mb-0 font-size-18"><a href="#" class="user-profile-show text-reset">Auto-Bot Workflows Builder</a></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Content Body Top Header -->

            <!-- start chat conversation section -->
            <div class="w-100 overflow-hidden position-relative">

                <div class="qr-code-container p-5">
                    <br><br><br><br>
                    <center>

                    <style>
                        .flowchart-example-container {
                            width: 800px;
                            height: 400px;
                            background: white;
                            border: 1px solid #BBB;
                            margin-bottom: 10px;
                        }
                    </style>

                    <h4>Flowchart</h4>
                    <div id="chart_container">
                        <div class="flowchart-example-container" id="flowchartworkspace"></div>
                    </div>
                    <div class="draggable_operators">
                        <div class="draggable_operators_label">
                            Operators (drag and drop them in the flowchart):
                        </div>
                        <div class="draggable_operators_divs">
                            <div class="draggable_operator btn btn-success" data-nb-inputs="1" data-nb-outputs="0">1 input</div>
                            <div class="draggable_operator btn btn-success" data-nb-inputs="0" data-nb-outputs="1">1 output</div>
                            <div class="draggable_operator btn btn-success" data-nb-inputs="1" data-nb-outputs="1">1 input &amp; 1 output</div>
                            <div class="draggable_operator btn btn-success" data-nb-inputs="1" data-nb-outputs="2">1 in &amp; 2 out</div>
                            <div class="draggable_operator btn btn-success" data-nb-inputs="2" data-nb-outputs="1">2 in &amp; 1 out</div>
                            <div class="draggable_operator btn btn-success" data-nb-inputs="2" data-nb-outputs="2">2 in &amp; 2 out</div>
                        </div>
                    </div>
                    <br><br>
                    <button class="delete_selected_button">Delete selected operator / link</button>
                    <div id="operator_properties" style="display: block;">
                        <label for="operator_title">Operator's title: </label><input id="operator_title" type="text">
                    </div>
                    <div id="link_properties" style="display: block;">
                        <label for="link_color">Link's color: </label><input id="link_color" type="color">
                    </div>
                    <button class="set_data" id="set_data">Load Workflow</button>
                    <button class="get_data" id="get_data">Save Workflow</button>
                    <div>
                        <form method="post" id="save_data_form">
                            <input type="hidden" name="action" value="workflows_save">
                            <input type="hidden" name="token" value="<?=$Token?>">
                            <input type="hidden" name="page" value="<?=$page?>">
                            <textarea id="flowchart_data" name="flowchart_data" style="display:none;"><?=$workflows?></textarea>
                        </form>
                    </div>
                    
                    <br><br>

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
<!-- Flowchart CSS and JS -->
<!-- jQuery & jQuery UI are required -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/assets/workflows/jquery.flowchart.css">
<script src="/assets/workflows/jquery.flowchart.js"></script>
<script type="text/javascript">
    /* global $ */
    $(document).ready(function() {
        var $flowchart = $('#flowchartworkspace');
        var $container = $flowchart.parent();


        // Apply the plugin on a standard, empty div...
        $flowchart.flowchart({
            data: defaultFlowchartData,
            defaultSelectedLinkColor: '#000055',
            grid: 10,
            multipleLinksOnInput: true,
            multipleLinksOnOutput: true
        });


        function getOperatorData($element) {
            var nbInputs = parseInt($element.data('nb-inputs'), 10);
            var nbOutputs = parseInt($element.data('nb-outputs'), 10);
            var data = {
                properties: {
                    title: $element.text(),
                    inputs: {},
                    outputs: {}
                }
            };

            var i = 0;
            for (i = 0; i < nbInputs; i++) {
                data.properties.inputs['input_' + i] = {
                    label: 'Input ' + (i + 1)
                };
            }
            for (i = 0; i < nbOutputs; i++) {
                data.properties.outputs['output_' + i] = {
                    label: 'Output ' + (i + 1)
                };
            }

            return data;
        }



        //-----------------------------------------
        //--- operator and link properties
        //--- start
        var $operatorProperties = $('#operator_properties');
        $operatorProperties.hide();
        var $linkProperties = $('#link_properties');
        $linkProperties.hide();
        var $operatorTitle = $('#operator_title');
        var $linkColor = $('#link_color');

        $flowchart.flowchart({
            onOperatorSelect: function(operatorId) {
                $operatorProperties.show();
                $operatorTitle.val($flowchart.flowchart('getOperatorTitle', operatorId));
                return true;
            },
            onOperatorUnselect: function() {
                $operatorProperties.hide();
                return true;
            },
            onLinkSelect: function(linkId) {
                $linkProperties.show();
                $linkColor.val($flowchart.flowchart('getLinkMainColor', linkId));
                return true;
            },
            onLinkUnselect: function() {
                $linkProperties.hide();
                return true;
            }
        });

        $operatorTitle.keyup(function() {
            var selectedOperatorId = $flowchart.flowchart('getSelectedOperatorId');
            if (selectedOperatorId != null) {
                $flowchart.flowchart('setOperatorTitle', selectedOperatorId, $operatorTitle.val());
            }
        });

        $linkColor.change(function() {
            var selectedLinkId = $flowchart.flowchart('getSelectedLinkId');
            if (selectedLinkId != null) {
                $flowchart.flowchart('setLinkMainColor', selectedLinkId, $linkColor.val());
            }
        });
        //--- end
        //--- operator and link properties
        //-----------------------------------------

        //-----------------------------------------
        //--- delete operator / link button
        //--- start
        $flowchart.parent().siblings('.delete_selected_button').click(function() {
            $flowchart.flowchart('deleteSelected');
        });
        //--- end
        //--- delete operator / link button
        //-----------------------------------------



        //-----------------------------------------
        //--- create operator button
        //--- start
        var operatorI = 0;
        $flowchart.parent().siblings('.create_operator').click(function() {
            var operatorId = 'created_operator_' + operatorI;
            var operatorData = {
                top: ($flowchart.height() / 2) - 30,
                left: ($flowchart.width() / 2) - 100 + (operatorI * 10),
                properties: {
                    title: 'Operator ' + (operatorI + 3),
                    inputs: {
                        input_1: {
                            label: 'Input 1',
                        }
                    },
                    outputs: {
                        output_1: {
                            label: 'Output 1',
                        }
                    }
                }
            };

            operatorI++;

            $flowchart.flowchart('createOperator', operatorId, operatorData);

        });
        //--- end
        //--- create operator button
        //-----------------------------------------




        //-----------------------------------------
        //--- draggable operators
        //--- start
        //var operatorId = 0;
        var $draggableOperators = $('.draggable_operator');
        $draggableOperators.draggable({
            cursor: "move",
            opacity: 0.7,

            // helper: 'clone',
            appendTo: 'body',
            zIndex: 1000,

            helper: function(e) {
                var $this = $(this);
                var data = getOperatorData($this);
                return $flowchart.flowchart('getOperatorElement', data);
            },
            stop: function(e, ui) {
                var $this = $(this);
                var elOffset = ui.offset;
                var containerOffset = $container.offset();
                if (elOffset.left > containerOffset.left &&
                    elOffset.top > containerOffset.top &&
                    elOffset.left < containerOffset.left + $container.width() &&
                    elOffset.top < containerOffset.top + $container.height()) {

                    var flowchartOffset = $flowchart.offset();

                    var relativeLeft = elOffset.left - flowchartOffset.left;
                    var relativeTop = elOffset.top - flowchartOffset.top;

                    var positionRatio = $flowchart.flowchart('getPositionRatio');
                    relativeLeft /= positionRatio;
                    relativeTop /= positionRatio;

                    var data = getOperatorData($this);
                    data.left = relativeLeft;
                    data.top = relativeTop;

                    $flowchart.flowchart('addOperator', data);
                }
            }
        });
        //--- end
        //--- draggable operators
        //-----------------------------------------


        //-----------------------------------------
        //--- save and load
        //--- start
        function Flow2Text() {
            var data = $flowchart.flowchart('getData');
            $('#flowchart_data').val(JSON.stringify(data, null, 2));
            document.getElementById('save_data_form').submit();
        }
        $('#get_data').click(Flow2Text);

        function Text2Flow() {
            var data = JSON.parse($('#flowchart_data').val());
            $flowchart.flowchart('setData', data);
        }
        $('#set_data').click(Text2Flow);

        /*global localStorage*/
        function SaveToLocalStorage() {
            if (typeof localStorage !== 'object') {
                alert('local storage not available');
                return;
            }
            Flow2Text();
            localStorage.setItem("stgLocalFlowChart", $('#flowchart_data').val());
        }
        $('#save_local').click(SaveToLocalStorage);

        function LoadFromLocalStorage() {
            if (typeof localStorage !== 'object') {
                alert('local storage not available');
                return;
            }
            var s = localStorage.getItem("stgLocalFlowChart");
            if (s != null) {
                $('#flowchart_data').val(s);
                Text2Flow();
            }
            else {
                alert('local storage empty');
            }
        }
        $('#load_local').click(LoadFromLocalStorage);
        //--- end
        //--- save and load
        //-----------------------------------------


    });

    var defaultFlowchartData = {
        operators: {
            operator1: {
                top: 20,
                left: 20,
                properties: {
                    title: 'Operator 1',
                    inputs: {},
                    outputs: {
                        output_1: {
                            label: 'Output 1',
                        }
                    }
                }
            },
            operator2: {
                top: 80,
                left: 300,
                properties: {
                    title: 'Operator 2',
                    inputs: {
                        input_1: {
                            label: 'Input 1',
                        },
                        input_2: {
                            label: 'Input 2',
                        },
                    },
                    outputs: {}
                }
            },
        },
        links: {
            link_1: {
                fromOperator: 'operator1',
                fromConnector: 'output_1',
                toOperator: 'operator2',
                toConnector: 'input_2',
            },
        }
    };
    if (false) console.log('remove lint unused warning', defaultFlowchartData);
</script>
<?php include("includes/htmlend.php"); ?>
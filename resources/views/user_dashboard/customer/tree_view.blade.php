@extends('user_dashboard.layouts.app')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    /* Copyright 2008 Google Inc. All Rights Reserved. */

    .google-visualization-orgchart-table {
        border: 0;
        text-align: center;
    }

    .google-visualization-orgchart-table * {
        margin: 0;
        padding: 2px;
    }

    .google-visualization-orgchart-space-small {
        width: 4px;
        height: 1px;
        border: 0;
    }

    .google-visualization-orgchart-space-medium {
        width: 10px;
        height: 1px;
        border: 0;
    }

    .google-visualization-orgchart-space-large {
        width: 16px;
        height: 1px;
        border: 0;
    }

    .google-visualization-orgchart-noderow-small {
        height: 12px;
        border: 0;
    }

    .google-visualization-orgchart-noderow-medium {
        height: 30px;
        border: 0;
    }

    .google-visualization-orgchart-noderow-large {
        height: 46px;
        border: 0;
    }

    .google-visualization-orgchart-connrow-small {
        height: 2px;
        font-size: 1px;
    }

    .google-visualization-orgchart-connrow-medium {
        height: 6px;
        font-size: 4px;
    }

    .google-visualization-orgchart-connrow-large {
        height: 10px;
        font-size: 8px;
    }

    .google-visualization-orgchart-node {
        text-align: center;
        vertical-align: middle;
        font-family: arial, helvetica;
        cursor: default;
        border: 2px solid #b5d9ea;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        -webkit-box-shadow: rgba(0, 0, 0, 0.5) 3px 3px 3px;
        -moz-box-shadow: rgba(0, 0, 0, 0.5) 3px 3px 3px;
        background-color: #edf7ff;
        background: -webkit-gradient(linear, left top, left bottom, from(#edf7ff), to(#cde7ee));
    }

    .google-visualization-orgchart-nodesel {
        border: 2px solid #e3ca4b;
        background-color: #fff7ae;
        background: -webkit-gradient(linear, left top, left bottom, from(#fff7ae), to(#eee79e));
    }

    .google-visualization-orgchart-node-small {
        font-size: 0.6em;
    }

    .google-visualization-orgchart-node-medium {
        font-size: 0.8em;
    }

    .google-visualization-orgchart-node-large {
        font-size: 1.2em;
        font-weight: bold;
    }

    .google-visualization-orgchart-linenode {
        border: 0;
    }

    .google-visualization-orgchart-lineleft {
        border-left: 1px solid #3388dd;
    }

    .google-visualization-orgchart-lineright {
        border-right: 1px solid #3388dd;
    }

    .google-visualization-orgchart-linebottom {
        border-bottom: 1px solid #3388dd;
    }

    .mytooltip {
        position: relative;
        display: inline-block;
    }

    .mytooltip .mytext {
        visibility: hidden;
        width: 220px;
        background-color: #1B2064;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        bottom: 75%;
        left: -35%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
        z-index: 9999;
    }

    .mytooltip .mytext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .mytooltip:hover .mytext {
        visibility: visible;
        opacity: 1;
    }

    @media(min-width: 320px) and (max-width:767px) {
        .mytooltip .mytext {
            margin-left: 0;
        }

        .mytooltip .mytext::after {
            left: 25%;
        }
    }

    .rspnsv {
        height: 71vh;
        width: 100%;
        overflow: scroll;
    }

    ::-webkit-scrollbar {
        width: 5px;
        border: 1px solid #d5d5d5;
    }

    ::-webkit-scrollbar-track {
        border-radius: 0;
        background: #eeeeee;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 0;
        background: #5e5959;
    }

    ::-webkit-scrollbar:horizontal {
        height: 5px;
        border: 1px solid #d5d5d5;
    }

    ::-webkit-scrollbar-thumb:horizontal {
        background: #5e5959;
        border-radius: 0;

    }
</style>
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid mt-0">
                <div class="card">
                    <div class="card-header pb-0 pt-1">
                        <div class="row">
                            <div class="col-md-3">
                                <form method="GET" action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="User Id"
                                            aria-label="User Id" name="referral_code">
                                        <button class="btn btn-dark waves-effect waves-light" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-9">
                                <div class="text-lg-end">
                                    <a href="{{ route('tree_view') }}" class="btn btn-danger mb-1 me-2"><i
                                            class="uil-user me-1"></i> Self</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content rspnsv">
            <div class="container-fluid mt-3">
                <div id="orgchart_div"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Function to fetch the MLM tree response from your server
        function fetchMLMTree() {
            return fetch(
                    '{{ route('mlm_tree') }}?referral_code={{ $referral_code }}'
                    ) // Replace with the actual endpoint to get the MLM tree response from your server
                .then((response) => response.json())
                .catch((error) => console.error('Error fetching MLM tree:', error));
        }

        // Function to draw the org chart using the MLM tree response
        function drawOrgChart(mlmTree) {
            google.charts.load('current', {
                packages: ['orgchart']
            });
            google.charts.setOnLoadCallback(() => {
                const chartData = new google.visualization.DataTable();
                chartData.addColumn('string', 'ID');
                chartData.addColumn('string', 'Parent');
                chartData.addColumn('string', 'Name');

                // Convert the MLM tree response to the format required by Google Org Chart
                const orgChartData = convertToOrgChartData(mlmTree);

                chartData.addRows(orgChartData);

                const chart = new google.visualization.OrgChart(document.getElementById('orgchart_div'));
                chart.draw(chartData, {
                    allowHtml: true
                });

                google.visualization.events.addListener(chart, 'onmouseover', function(e) {
                    setTooltipContent(chartData, e.row);
                });

                function setTooltipContent(dataTable, row) {
                    if (row != null) {
                        var str = dataTable.getValue(row, 0);
                        var tooltip = document.getElementsByClassName("google-visualization-tooltip")[0];
                        if (str != '') {
                            $.ajax({
                                type: 'GET',
                                url: "{{ route('referral_details') }}",
                                data: 'referral_code=' + str,
                                success: function(resp) {
                                    if (resp != '') {
                                        $("#my" + str).html(resp);
                                    }
                                }
                            });
                        }
                    }
                }

            });
        }

        // Function to convert MLM tree response to Google Org Chart format
        function convertToOrgChartData(node) {
            const orgChartData = [];
            if (node) {
                orgChartData.push([{
                    'v': node.v.toString(),
                    'f': node.f
                }, node.p ? node.p.toString() : '', '']);
                if (node.c && node.c.length > 0) {
                    node.c.forEach((child) => {
                        orgChartData.push(...convertToOrgChartData(child));
                    });
                }
            }
            return orgChartData;
        }

        // Fetch the MLM tree response and draw the org chart
        fetchMLMTree().then((mlmTree) => {
            drawOrgChart(mlmTree);
        });
    </script>
@endsection

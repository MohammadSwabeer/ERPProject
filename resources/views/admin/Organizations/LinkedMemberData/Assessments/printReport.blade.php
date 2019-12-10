<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link href="{{URL::asset('adminAssets/css/main-responsive.css')}}" rel="stylesheet">
    <link href="{{URL::asset('adminAssets/icons/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('adminAssets/css/material-bootstrap-wizard.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('adminAssets/css/style.min.css')}}" rel="stylesheet">
</head>
<body>

   @foreach($post as $posts)
	 <div class="row" id="printableArea">
       <div class="col-md-12">
          <div class="card card-body printableArea">
            <h3><b>Report</b><span class="pull-right">Hidayah-Foundation</span></h3>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="pull-left">
                  <address>
                    <h3> &nbsp;<b class="text-danger">{{$posts->member_fname}} {{$posts->member_mname}} {{$posts->member_lname}}</b></h3>
                    <p class="text-muted m-l-5">{{$posts->permanent_address}},
                      <br/>{{$posts->p_residence}},
                      <br/> {{$posts->contact}}
                    </p>
                  </address>
                </div>
                <div class="pull-right text-right">
                  <address>
                    <!-- <h3>To,</h3> -->
                    <h4 class="font-bold">Hidayah {{$type}},</h4>
                    <p class="text-muted m-l-30">Unit : Mangalore</p>
                    <p class="m-t-30"><b>Date : 2018-02-26  </b> <i class="fa fa-calendar"></i> </p>
                  </address>
                </div>
              </div>
              <div class="col-md-12">
                <div class="table-responsive m-t-40" style="clear: both;">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th>Description</th>
                        <th>Earned Credits</th>
                        <th class="text-right">Total Credits</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="4"><b>Physical Credits :</b></td>
                      </tr>
                      <tr>
                        <td class="text-center"><b>Meetings :</b></td>
                      </tr>
                      <tr>
                        <td class="text-center">1</td>
                        <td>Regular Meetings</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>
                      <tr>
                        <td class="text-center">2</td>
                        <td>Workshop</td>
                        <td class="">100</td>

                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">3</td>
                        <td>Global Meet</td>
                        <td class="">200</td>
                        <td class="text-right">200</td>
                      </tr>

                      <tr>
                        <td class="text-center">4</td>
                        <td>Conference National/ International</td>
                        <td class="">200</td>
                        <td class="text-right">200</td>
                      </tr>

                      <tr>
                        <td colspan="4" class="text-right">
                         <b>Meetings Total : 600</b>
                        </td>
                      </tr>
                      <!-- Vists -->
                      <tr>
                        <td class="text-center"><b>Visits :</b></td>
                      </tr>
                      <tr>
                        <td class="text-center">1</td>
                        <td>HSCC</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>
                      <tr>
                        <td class="text-center">2</td>
                        <td>Rural</td>
                        <td class="text-danger">0</td>

                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">3</td>
                        <td>Hospital</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">4</td>
                        <td>Educational Institution</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">5</td>
                        <td>Survey And Distribtion</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>
                      <tr>
                        <td colspan="4" class="text-right">
                         <b>Visits Total : 400</b>
                        </td>
                      </tr>
                      <!-- Network -->
                      <tr>
                        <td class="text-center"><b>Network :</b></td>
                      </tr>
                      <tr>
                        <td class="text-center">1</td>
                        <td>Addition of Quality Member</td>
                        <td class="">100</td>
                        <td class="text-right">200</td>
                      </tr>
                      <tr>
                        <td class="text-center">2</td>
                        <td>Adding Potential Donor</td>
                        <td class="">200</td>

                        <td class="text-right">200</td>
                      </tr>

                      <tr>
                        <td class="text-center">3</td>
                        <td>Intellectuals/ Resource Persons</td>
                        <td class="">150</td>
                        <td class="text-right">200</td>
                      </tr>
                      <tr>
                        <td colspan="4" class="text-right">
                         <b>Network Total : 450</b>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4" class="text-right">
                         <b>Physical Credits Total : 1450</b>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4"><b> Intellectual Credits :</b></td>
                      </tr>
                      <tr>
                        <td class="text-center"><b>Project Knowledge :</b></td>
                      </tr>
                      <tr>
                        <td class="text-center">1</td>
                        <td>Research Work</td>
                        <td class="">150</td>
                        <td class="text-right">200</td>
                      </tr>
                      <tr>
                        <td class="text-center">2</td>
                        <td>System Development and Project Design</td>
                        <td class="">100</td>

                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">3</td>
                        <td>Presentation</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">4</td>
                        <td>Group Discussion</td>
                        <td class="">50</td>
                        <td class="text-right">50</td>
                      </tr>

                      <tr>
                        <td class="text-center">5</td>
                        <td>Project Updates</td>
                        <td class="">50</td>
                        <td class="text-right">50</td>
                      </tr>
                      <tr>
                        <td colspan="4" class="text-right">
                         <b>Intellectual Credits (Project Knowledge) Total : 450</b>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="4"><b> Financial Credits :</b></td>
                      </tr>
                      <tr>
                        <td class="text-center">1</td>
                        <td>Food</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>
                      <tr>
                        <td class="text-center">2</td>
                        <td>Health</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">3</td>
                        <td>Education</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">4</td>
                        <td>Self -Reliance</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">5</td>
                        <td>Infrastructure</td>
                        <td class="">100</td>
                        <td class="text-right">100</td>
                      </tr>

                      <tr>
                        <td class="text-center">5</td>
                        <td>Other</td>
                        <td class="">50</td>
                        <td class="text-right">100</td>
                      </tr>
                      <tr>
                        <td colspan="4" class="text-right">
                         <b>Financial Total : 550</b>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-12">
                <div class="pull-right m-t-30 text-right">
                  <hr>
                  <h3><b>Grand Total : </b> <span class="text-muted">2550 </span> </h3>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
   @endforeach
<script type="text/javascript">
 	window.print();
</script>
</body>
</html>

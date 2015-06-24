<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav">
                <?=isset($report_form)?$this->load->view($report_form):info_template('No form to display')?>
            </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">


            <div class="widget widget-table">


                <div class="widget-header"><h3> <?=isset($subtitle)?$subtitle:""?> </h3> </div>


                <div class="widget-content">


                    <div class="table-responsive">



                        <div class="message">
                            <p>
                                <?=isset($quarter)?$quarter:''?>
                            </p>


                            <?=isset($report_view)?$this->load->view($report_view):info_template('No view to display')?>



                        </div>
                    </div>

                </div>
            </div>

        </div><!--/span-->
    </div><!--/row-->

    <hr>



    <script type="text/javascript" src="<?= base_url() ?>assets/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/DataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
    <script>

        $(document).ready(function(){



            $('table.display').dataTable({
                paging: false,
                responsive: true,


                "order": [[ 3, "asc" ]]


            });

            $('table.summary_report').dataTable({
                paging: false,
                bFilter: false,
                responsive: true,
                "order": [[ 3, "asc" ]]



            });



            $('#selector1').select2();
            $('.populate').select2();


            $('.number').each(function () {
                var $this = $(this);
                jQuery({Counter: 0}).animate({Counter: $this.text()}, {
                    duration: 1000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });








        });

        function printContent(el){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }




















    </script>




</div>
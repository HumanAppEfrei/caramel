<div class="well">
    <legend>Segments</legend>

    <div class="tabbable" id="segments">
        <ul class="nav nav-tabs">
            <li><a href="#seg_by_dons" >Versements par segments</a></li>
            <li><a href="#contact_by_seg" >Contacts par segments</a></li>
        </ul>
    </div>

    <div class="tabSegments" id="seg_by_dons">
        <div id="seg_by_dons"></div>
    </div>
    <div class="tabSegments" id="contact_by_seg">
        <div id="contact_by_seg"></div>
    </div>
</div>
</div>

<script language="javascript" type="text/javascript">



    $(function() {
        var data = [
<?php
$i = 0;
foreach ($cols_seg_by_dons as $col) {
    echo (' {label: "' . $col . '", data:' . $rows_seg_by_dons[$col] . '}, ');
}
?>
        ];
        var options = {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
<?php if ($exp_vers == 'valeur') { ?>formatter: function(label, series) {
                                                                                return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '% (' + series.data[0][1] + ' €)' + '</div>';
                                                                            },
<?php } else {
    ?>formatter: function(label, series) {
                                                                                return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '% (' + series.data[0][1] + ')' + '</div>';
                                                                            },
<?php } ?>
                                                                        background: {
                                                                            opacity: 0.5
                                                                        }
                                                                    }
                                                                }
                                                            },
                                                            legend: {
                                                                show: false
                                                            }
                                                        };
                                                        var seg_by_dons = $("#seg_by_dons");
                                                        seg_by_dons.css("height", "250px");
                                                        seg_by_dons.css("width", "500px");
                                                        $.plot(seg_by_dons, data, options);
                                                    });



                                                    $(function() {
                                                        var data = [
<?php
$i = 0;
foreach ($cols_contact_by_seg as $col) {
    echo (' {label: "' . $col . '", data:' . $rows_contact_by_seg[$col] . '}, ');
}
?>
                                                        ];
                                                        var options = {
                                                            series: {
                                                                pie: {
                                                                    show: true,
                                                                    radius: 1,
                                                                    label: {
                                                                        show: true,
                                                                        radius: 3 / 4,
                                                                        formatter: function(label, series) {
                                                                            return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '% (' + series.data[0][1] + ')' + '</div>';
                                                                        },
                                                                        background: {
                                                                            opacity: 0.5
                                                                        }
                                                                    }
                                                                }
                                                            },
                                                            legend: {
                                                                show: false
                                                            }
                                                        };
                                                        var contact_by_seg = $("#contact_by_seg");
                                                        contact_by_seg.css("height", "250px");
                                                        contact_by_seg.css("width", "500px");
                                                        $.plot(contact_by_seg, data, options);
                                                    });


                                                    $(document).ready(function() {
                                                        $(".tabSegments").each(function(i) {
                                                            this.id = "#" + this.id;
                                                        });

                                                        $(".tabSegments:not(:first)").hide();
                                                        $(".tabSegments").not(":first").hide();

                                                        $("#segments a").click(function() {
                                                            var idTab_do = $(this).attr("href");
                                                            $(".tabSegments").hide();
                                                            $("div[id='" + idTab_do + "']").fadeIn();
                                                            return false;
                                                        });
                                                    });
</script>  
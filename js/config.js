Number.prototype.toMoney = function (decimals, decimal_sep, thousands_sep) {
        var n = this;
        decimals = decimals || 0;
        decimal_sep = decimal_sep || ',';
        thousands_sep = thousands_sep || '.';
        var sign = n < 0 ? "-" : "",
            i = parseInt( n = Math.abs(n).toFixed(decimals) ) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return sign + (j ? i.slice(0, j) + thousands_sep : "") + i.slice(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep) + (decimals ? decimal_sep + Math.abs(n - i).toFixed(decimals).slice(2) : "");
    }

    var position = null; 
    var geocoder = new google.maps.Geocoder;
     
  
    function setMap(lat, lng, alamat, data) {
        var custom_position = {lat: lat, lng: lng};   
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: custom_position
        });

        new google.maps.Marker({
          position: position,
          map: map,
          icon: "http://i.imgur.com/S1ooXKy.png", 
        });  

        marker = new google.maps.Marker({
          position: custom_position,
          map: map, 
          animation: google.maps.Animation.BOUNCE,
        });  

        var infowindow = new google.maps.InfoWindow({ maxWidth: 300 });
        var content = "<table>";
        content += "    <tr>";
        content += "        <td colspan='3'>Kos: <b>"+data.nama+"</b></td>";
        content += "    </tr>";
        content += "    <tr>";
        content += "        <td width='50px' valign='top'>Alamat</td>";
        content += "        <td width='5px' valign='top'>:</td>";
        content += "        <td valign='top'>"+alamat[0]+"</td>";
        content += "    </tr>";
        content += "    <tr>";
        content += "        <td valign='top'>Lokasi</td>";
        content += "        <td valign='top'>:</td>";
        content += "        <td valign='top'>"+alamat[1]+"</td>";
        content += "    </tr>";
        content += "</table>";
        infowindow.setContent(content);
        infowindow.open(map, marker);
 
    } 

    var loader = "<img width='60px' src='img/loading.gif' />";
 
    $(document).ready(function() {
        $('[bSearchKos]').click(function() { 
            $('.list_kos table tbody').html(loader);
            $('[lokasi_terdeteksi]').text('-');

            var address = $('[name="search"]').val();
            var jarak = $('[name="jarak"]').val();
            var harga = $('[name="harga"]').val();
            geocoder.geocode({'address': address}, function (results, status) { 
                if (status == google.maps.GeocoderStatus.OK) {  

                    position = {
                        lat: results[0].geometry.location.lat(),
                        lng: results[0].geometry.location.lng()
                    };

                    $('[lokasi_terdeteksi]').text(results[0].formatted_address);

                    $.ajax({
                        url: 'cari.php',
                        data: "lat="+results[0].geometry.location.lat()+"&lng="+results[0].geometry.location.lng()+"&jarak="+jarak+"&harga="+harga,
                        dataType: 'json',
                        cache: true,
                        success: function(msg){
                          if(msg.length > 0) {
                            var html = "";
                            $.each(msg, function(k, v) {
                                var img = "";
                                if(v.gambar != '') {
                                    img = v.gambar.split(';');
                                    if(typeof(img[0]) != 'undefined') {
                                        img = "<img width='400px' height='250px' src='gambar_kos/"+img[0]+"' />";
                                    } else {
                                        img = "";
                                    }
                                }
                                html += "<tr>";
                                html += "   <td rowspan=6>"+img+"</td>";
                                html += "   <td colspan=2 align=center><b>"+v.nama+"</b></td>";
                                html += "</tr>";
                                html += "<tr>";
                                html += "   <td><b>Pemilik Kosan<b></td>";
                                html += "   <td align=right>"+v.nama_pemilik+"</td>";
                                html += "</tr>";
                                html += "<tr>";
                                html += "   <td><b>Alamat<b></td>";
                                html += "   <td align=right>"+v.alamat+"</td>";
                                html += "</tr>";
                                html += "<tr>";
                                html += "   <td><b>Jarak<b></td>";
                                html += "   <td align=right>"+parseFloat(v.jarak).toFixed(2)+" km</td>";
                                html += "</tr>";
                                html += "<tr>";
                                html += "   <td><b>Harga<b></td>";
                                html += "   <td align=right>"+parseFloat(v.harga).toMoney()+" @"+v.periode_sewa+"</td>";
                                html += "</tr>";
                                html += "<tr>";
                                html += "   <td colspan=2 align=center>";
                                html += "       <button bLihatPeta='"+v.latitude+'|'+v.longitude+"' alamat_map='"+v.alamat_map+"' alamat='"+v.alamat+"' data='"+JSON.stringify(v)+"'>Lihat Peta</button>";
                                html += "   </td>";
                                html += "</tr>";
                                html += "<tr>";
                                html += "   <td colspan=3>";
                                html += "       <hr /><br /><br />";
                                html += "   </td>";
                                html += "</tr>";    
                            });
                            $('.list_kos table tbody').html(html);
                          } else {
                            html += "<tr>";
                            html += "   <td>Kos tidak ditemukan disekitar lokasi</td>"; 
                            html += "</tr>"; 
                            $('.list_kos table tbody').html(html);
                          }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            $('.list_kos table tbody').html(html);
                            alert("Terjadi kesalahan jaringan");
                        }
                    }); 
                } else {
                    $('.list_kos table tbody').html('');
                    alert("Lokasi tidak ditemukan");
                }
            });

        });

        $('body').on('click', '[bLihatPeta]', function() {
            $('[popup_map] #map').html('');
            var c = $(this).attr('bLihatPeta');
            var alamat = [$(this).attr('alamat'), $(this).attr('alamat_map')]; 
            var data = $(this).attr('data');
            if(c != '') { 
                c = c.split('|');
                var lat = parseFloat(c[0]);
                var lng = parseFloat(c[1]);
                setMap(lat, lng, alamat, JSON.parse(data));
                $('[popup_map]').show();
            } 
        }); 
        
        $('[popup_map] [bClose]').click(function() {
            $('[popup_map]').hide();
            $('[popup_map] #map').html('');
        });
    });



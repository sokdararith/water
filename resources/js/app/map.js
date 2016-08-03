var employee = new kendo.data.DataSource({
        transport: {
          read: {
            url: ARNY.baseUrl + "api/employees/index/6",
            dataType: "json",
            type: "GET"
          }
        }
  });
  $('#map').kendoMap({
    dataSource: employee,
    title: "my map",
    latField: "latitute",
    lngField: "longtitute",
    map: {
      options: {
        zoom: 18
      }
    },
    fitBounds: true,
    marker: {
      template: kendo.template($("#marker-tmpl").html()),
      options: {
      animation: google.maps.Animation,
      draggable: true
    }
    }
  });
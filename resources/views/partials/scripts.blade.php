<script src="{{ asset('Assets/en/js/jquery.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/popper.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/moment.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/simplebar.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/daterangepicker.js') }}"></script>
<script src="{{ asset('Assets/en/js/jquery.stickOnScroll.js') }}"></script>
<script src="{{ asset('Assets/en/js/tinycolor-min.js') }}"></script>
<script src="{{ asset('Assets/en/js/config.js') }}"></script>
<script src="{{ asset('Assets/en/js/d3.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/topojson.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/datamaps.all.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/datamaps-zoomto.js') }}"></script>
<script src="{{ asset('Assets/en/js/datamaps.custom.js') }}"></script>
<script src="{{ asset('Assets/en/js/Chart.min.js') }}"></script>
<script>
/* define global options */
  Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
  Chart.defaults.global.defaultFontColor = colors.mutedColor;
</script>


<!--  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vfs_fonts/2.0.0/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/stick-on-scroll"></script>


<script src="{{ asset('Assets/en/js/gauge.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/apexcharts.custom.js') }}"></script>
<script src="{{ asset('Assets/en/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/select2.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/jquery.steps.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/jquery.timepicker.js') }}"></script>
<script src="{{ asset('Assets/en/js/dropzone.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/uppy.min.js') }}"></script>
<script src="{{ asset('Assets/en/js/quill.min.js') }}"></script>
<script>
  // Initialize all select2 elements
  $('.select2').select2({
    theme: 'bootstrap4',
  });

  // Initialize permission select with additional features
  $('#permissionSelect').select2({
    placeholder: 'Select permissions...',
    allowClear: true,
    width: '100%',
    theme: 'bootstrap4',
    dropdownCssClass: 'select2-dropdown',
    language: {
      noResults: function() {
        return 'No permissions found';
      }
    }
  });
  $('.select2-multi').select2(
  {
    multiple: true,
    theme: 'bootstrap4',
  });
  $('.drgpicker').daterangepicker(
  {
    singleDatePicker: true,
    timePicker: false,
    showDropdowns: true,
    locale:
    {
      format: 'MM/DD/YYYY'
    }
  });
  $('.time-input').timepicker(
  {
    'scrollDefault': 'now',
    'zindex': '9999' /* fix modal open */
  });
  /** date range picker */
  if ($('.datetimes').length)
  {
    $('.datetimes').daterangepicker(
    {
      timePicker: true,
      startDate: moment().startOf('hour'),
      endDate: moment().startOf('hour').add(32, 'hour'),
      locale:
      {
        format: 'M/DD hh:mm A'
      }
    });
  }
  var start = moment().subtract(29, 'days');
  var end = moment();

  function cb(start, end)
  {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }
  $('#reportrange').daterangepicker(
  {
    startDate: start,
    endDate: end,
    ranges:
    {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
  }, cb);
  cb(start, end);
  $('.input-placeholder').mask("00/00/0000",
  {
    placeholder: "__/__/____"
  });
  $('.input-zip').mask('00000-000',
  {
    placeholder: "____-___"
  });
  $('.input-money').mask("#.##0,00",
  {
    reverse: true
  });
  $('.input-phoneus').mask('(000) 000-0000');
  $('.input-mixed').mask('AAA 000-S0S');
  $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ',
  {
    translation:
    {
      'Z':
      {
        pattern: /[0-9]/,
        optional: true
      }
    },
    placeholder: "___.___.___.___"
  });
  // editor
  var editor = document.getElementById('editor');
  if (editor)
  {
    var toolbarOptions = [
      [
      {
        'font': []
      }],
      [
      {
        'header': [1, 2, 3, 4, 5, 6, false]
      }],
      ['bold', 'italic', 'underline', 'strike'],
      ['blockquote', 'code-block'],
      [
      {
        'header': 1
      },
      {
        'header': 2
      }],
      [
      {
        'list': 'ordered'
      },
      {
        'list': 'bullet'
      }],
      [
      {
        'script': 'sub'
      },
      {
        'script': 'super'
      }],
      [
      {
        'indent': '-1'
      },
      {
        'indent': '+1'
      }], // outdent/indent
      [
      {
        'direction': 'rtl'
      }], // text direction
      [
      {
        'color': []
      },
      {
        'background': []
      }], // dropdown with defaults from theme
      [
      {
        'align': []
      }],
      ['clean'] // remove formatting button
    ];
    var quill = new Quill(editor,
    {
      modules:
      {
        toolbar: toolbarOptions
      },
      theme: 'snow'
    });
  }
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function()
  {
    'use strict';
    window.addEventListener('load', function()
    {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form)
      {
        form.addEventListener('submit', function(event)
        {
          if (form.checkValidity() === false)
          {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>
    <script>
      var uptarg = document.getElementById('drag-drop-area');
      if (uptarg)
      {
        var uppy = Uppy.Core().use(Uppy.Dashboard,
        {
          inline: true,
          target: uptarg,
          proudlyDisplayPoweredByUppy: false,
          theme: 'dark',
          width: 770,
          height: 210,
          plugins: ['Webcam']
        }).use(Uppy.Tus,
        {
          endpoint: 'https://master.tus.io/files/'
        });
        uppy.on('complete', (result) =>
        {
          console.log('Upload complete! We’ve uploaded these files:', result.successful)
        });
      }
    </script>
    <script   src="{{ asset('Assets/en/js/apps.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>

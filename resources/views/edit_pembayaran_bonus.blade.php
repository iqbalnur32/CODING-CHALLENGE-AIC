@extends('main')
@section('content')
  <div id="app">
    <form>
      <div class="container">
        <div class="card">
          <div class="card-header">
            <h1>Edit Payment Form {{ $data[0]->uniq_code }}</h1>
            <div class="float-right">
              <button type="button" id="addBuruhBtn" class="btn btn-primary">Add Buruh</button>
              <a href="{{ route('formPembayaranBonus.index') }}" class="btn btn-primary">Back</a>
              <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
              {{--<button type="button" id="removeLastBuruhBtn" class="btn btn-danger">Remove Field Last Buruh</button>--}}
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="totalBonus">Total Bonus</label>
              <input type="text" id="totalBonus" class="form-control" value="{{ number_format($data[0]->total_bonus) }}">
            </div>
            <div id="buruhInput">
              @foreach($data as $d)
              <div class="form-group">
                <label for="">{{ $d->name }}</label>
                <div class="input-group mb-3">
                  <input type="number" class="form-control percentage" id="percentage_{{ $d->id }}" required value="{{ $d->persentase }}">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
                    <button class="btn btn-danger delete-field" type="button" @click="deletePembayaranById('{{ $d->id }}')">Delete</button>
                  </div>
                </div>
                <input type="text" class="id_pembayaran" hidden value="{{ $d->id }}">
              </div>
              @endforeach
            </div>
            <div class="float-right">
              <button type="button" class="btn btn-primary" @click="updateData">Simpan</button>
            </div>
          </div>
          <div class="card-footer">
            <div id="bonusPerPerson">
              @foreach($data as $d)
              <div class="form-group">
                <label for="">{{ $d->name }}</label>
                <span id="person_{{ $d->id }}">{{ number_format($d->pembayaran) }}</span>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
@section('js')

<script>
  $(document).ready(function() {

    // Add Field Buruh
    $("#addBuruhBtn").click(function() {
      let html = `
        <div class="form-group">
          <label for="">Buruh ${$("#buruhInput").children().length + 1}</label>
          <div class="input-group mb-3">
            <input type="number" class="form-control percentage" id="percentage_${$("#buruhInput").children().length + 1}" required>
            <div class="input-group-append">
              <span class="input-group-text" id="basic-addon2">%</span>
              <button class="btn btn-danger delete-field" onclick="removeField()" type="button">Delete</button>
            </div>
            <input type="text" class="form-control id_pembayaran" hidden value="${$("#buruhInput").children().length + 1}">
          </div>
        </div>
      `;
      let html2 = `
      <div class="form-group">
          <label for="">Buruh ${$("#buruhInput").children().length + 1}</label>
          <span id="person_${$("#buruhInput").children().length + 1}"></span>
        </div>
      </div>
      `

      $("#buruhInput").append(html);
      $("#bonusPerPerson").append(html2);
    })

    // Remove Last Field
    $("#removeLastBuruhBtn").on("click", function() {
      $("#buruhInput").children().last().remove();
      $("#bonusPerPerson").children().last().remove();
    });

    $(".delete-field").on("click", function() {
      $("#buruhInput").children().last().remove();
      $("#bonusPerPerson").children().last().remove();
    });

    $(document).on('input', '.percentage', function() {
      calculateBonus(); // kalkulasi persetase berdasrkan total bonus pembayaran
    });

    var tanpa_rupiah = document.getElementById('totalBonus');
    tanpa_rupiah.addEventListener('keyup', function(e) {
      tanpa_rupiah.value = formatRupiah(this.value);
    });
  });

  function removeField() {
    $("#buruhInput").children().last().remove();
    $("#bonusPerPerson").children().last().remove();
  }

  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }

  function calculateBonus() {
    var totalBonus = $('#totalBonus').val().replace(/\D/g, '');
    totalBonus = parseInt(totalBonus);
    const percentages = $('.percentage').map(function() {
      return parseInt($(this).val());
    }).get();
    const bonusPerPerson = percentages.map(percentage => (percentage / 100) * totalBonus);
    $('#bonusPerPerson').empty();
    bonusPerPerson.forEach((bonus, index) => {
      $("#bonusPerPerson").append(`
          <div class="form-group">
            <label for="">Buruh ${index + 1}</label>
            <span id="person_${index + 1}">${bonus.toLocaleString('id-ID')}</span>
          </div>
        `)
    });
  }

  new Vue({
    el: '#app',
    data() {
      return {
        totalBonus: 0,
        percentages: [],
        bonusPerPerson: [],
        id: []
      }
    },
    methods: {
      updateData() {
        this.totalBonus = $('#totalBonus').val().replace(/\D/g, '');
        this.percentages = $('.percentage').map(function() {
          return parseInt($(this).val());
        }).get();
        this.id = $('.id_pembayaran').map(function() {
          return parseInt($(this).val());
        }).get();
        this.bonusPerPerson = this.percentages.map(percentage => (percentage / 100) * this.totalBonus);
        const totalPercentage = this.percentages.reduce((a, b) => a + b, 0);

        if (totalPercentage !== 100) {
          swal("info", "Persentase harus 100%", "info");
          return;
        }
        if(this.percentages.length < 3) {
          swal("info", "Minimal 3 buruh", "info");
          return;
        }

        let data = {
          id: this.id,
          totalBonus: this.totalBonus,
          percentages: this.percentages,
          bonusPerPerson: this.bonusPerPerson,
          uniqueCode: '{{$data[0]->uniq_code}}'
        }
        // console.log(data)

        fetch('/form/update/{{$data[0]->uniq_code}}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
          })
          .then(response => response.json())
          .then(data => {
            if (data.code == 200) {
              swal({
                title: "Success",
                text: data.message,
                icon: "success",
                button: "Ok",
              }).
              then((value) => {
                location.reload();
              });
            }
          })
          .catch(error => {
            // alert('Data Gagal Disimpan');
            swal("Error", "Data Gagal Disimpan", "error");
          });
      },
      deletePembayaranById(id) {
        fetch('{{ route('formPembayaranBonus.deletePembayaranById') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            uniqueCode: '{{$data[0]->uniq_code}}',
            id: id
          })
        })
        .then(response => console.log(response))
        .catch(error =>  console.log(error));
      }
    }
  })
</script>

@endsection
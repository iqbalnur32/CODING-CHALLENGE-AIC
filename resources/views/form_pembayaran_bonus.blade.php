@extends('main')
@section('content')
  <div id="app">
    <div class="container">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">List Form Pembayaran</h3>
            <a href="{{ route('formPembayaranBonus.index') }}" class="btn btn-primary">Back</a>
            <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
          </div>
          <div class="card-body">
            <div class="float-right">
              <a href="{{ route('formPembayaranBonus.add') }}" class="btn btn-primary">Add Form</a>
            </div>
            <div class="table-responsive py-5">
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">UniqCode</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script>
  function deletePembayaranByUniqCode(id) {
    fetch('{{route('formPembayaranBonus.deletePembayaranByUniqCode', ':id')}}'.replace(':id', id), {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
    .then(response => response.json())
    .then(data => {
      alert(data.message);
      location.reload();
    })
    .catch(error => console.log(error))
  }
</script>
<script>
  var app = new Vue({
    el: '#app',
    data: {
      items: [],
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      fetchData() {
        fetch('{{ route('formPembayaranBonus.list') }}', {
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            })
          .then(response => response.json())
          .then(data => {
            this.items = data
            this.items.forEach(item => {
              document.getElementById('tbody').innerHTML += '<tr><td>' + item.no + '</td><td>' + item.uniq_code + '</td><td>' + item.action + '</td></tr>'
            })
          })
          .catch(error => console.log(error))
      }
    }
  });
</script>
@endsection
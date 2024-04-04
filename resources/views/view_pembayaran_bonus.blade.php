@extends('main')
@section('content')
  <div id="app">
    <form>
      <div class="container">
        <div class="card">
          <div class="card-header">
            <h1>View Payment Form {{ $data[0]->uniq_code }}</h1>
            <a href="{{ route('formPembayaranBonus.index') }}" class="btn btn-primary">Back</a>
            <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="totalBonus">Total Bonus</label>
              <input type="text" id="totalBonus" class="form-control" disabled value="{{ number_format($data[0]->total_bonus) }}">
            </div>
            <div id="buruhInput">
              @foreach($data as $d)
              <div class="form-group">
                <label for="">{{ $d->name }}</label>
                <div class="input-group mb-3">
                  <input type="number" class="form-control percentage" disabled id="percentage_{{ $d->id }}" required value="{{ $d->persentase }}">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
                  </div>
                </div>
                <input type="text" class="id_pembayaran" hidden value="{{ $d->id }}">
              </div>
              @endforeach
            </div>
            <div class="float-right">
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
@endsection
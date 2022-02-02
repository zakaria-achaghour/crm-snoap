<div class="row-fluid">
  <div class="widget-box">
      <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
          <h5>{{__('List Of Users')}}</h5>
          <a href="{{ route('exporter_view',['user',0]) }}"target="_blank" class="btn btn-success btn-mini add-action">
            <i class="icon icon-download-alt"></i> Exporter</a>
      </div>
<div class="widget-content nopadding">
<table id="table" class="table table-bordered data-table">
    <thead>
        <tr>
            <th>{{__('Username') }}</th>
            <th>{{__('Firstname')}}</th>
            <th>{{__('Lastname')}}</th>
            <th>{{__('E-mail')}}</th>
            <th>{{__('Gender')}}</th>
            <th>{{__('Contact')}}</th>
            <th>{{__('Role')}}</th>
      
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->firstname }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->gender }}</td>
                <td>{{ $user->contact }}</td>
                <td> 
                  {{ implode(', ',$user->roles()->get()->pluck('name')->toArray()) }}
              </td>
           
                <td>
                    
                    <a class="tip btn btn-danger btn-mini " href="#activation{{ $user->id }}" data-toggle="modal" title="Supprimer">Débloqué</a> 
                    <div id="activation{{ $user->id }}" class="modal hide">
                      <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                        <h3>débloqué Confirmations</h3>
                      </div>
                      <div class="modal-body">
                        <p>Voulez-vous vraiment débloqué ?</p>
                      </div>
                      <div class="modal-footer"> 
                        <a href="{{ route('users.restore',['id'=>$user->id]) }}" class="btn btn-warning">Débloqué</a> 
                        <a href=""  data-dismiss="modal" class="btn btn-primary"> {{__('Close')}}</a> 
                      </div>
                    </div>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
</div>
  </div>
<script src="{{ asset('layout/js/matrix.tables.js') }}"></script>

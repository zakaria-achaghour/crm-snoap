<div class="control-group">
    <label for="firstname" class="control-label ">{{ __('Firstname') }}</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('firstname') is-invalid @enderror" name="firstname"
            id="firstname" placeholder="{{ __('Firstname Here') }}"
            value="{{ old('firstname', $user->firstname ?? null) }}">
        @error('firstname')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>



<div class="control-group">
    <label for="firstname" class="control-label ">{{ __('Lastname') }}</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('lastname') is-invalid @enderror" name="lastname"
            id="lastname" placeholder="{{ __('Lastname Here') }}"
            value="{{ old('lastname', $user->lastname ?? null) }}">
        @error('lastname')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label for="firstname" class="control-label ">{{__('E-mail')}}</label>
    <div class="controls ">
        <input id="email" name="email" type="text"
        class="form-control span8 @error('email') is-invalid @enderror"placeholder="email@email.com"
        value="{{ old('email', $user->email ?? null) }}">
        @error('email')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
        @enderror
    </div>
</div>

<div class="control-group">
    <label for="firstname" class="control-label ">{{__('Contact')}}</label>
    <div class="controls ">
        <input type="text" class="form-control span8 @error('contact') is-invalid @enderror" name="contact" id="cono1"
        placeholder="+ 212 6 ..." value="{{ old('contact', $user->contact ?? null) }}">
        @error('contact')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
</div>

<div class="control-group">
    <label class="control-label">{{__('Gender')}}</label>
    <div class="controls">
        <label class="" for="gender"  >
            <input type="radio" class=" @error('gender') is-invalid @enderror"
                id="gender" name="gender" value="male" required checked  {{ old('gender',isset($user) ? ($user->gender === 'male' ? 'checked' : ''):'') }}>
               {{__('Male')}}
            </label>
      <label>
        <label class="" for="gender2">

            <input type="radio" class=" @error('gender') is-invalid @enderror"
                id="gender2" name="gender" value="female" required {{ old('gender',isset($user) ? ($user->gender === 'female' ? 'checked' : ''):'') }}>
        
                {{__('Female')}}</label>     
      <label>
        @error('gender')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
   
  </div>



  <div class="control-group">
    <label class="control-label" for="role">{{__('Select Role')}}</label>
    <div class="controls">
      <select multiple class="form-control span8 @error('role') is-invalid @enderror" id="role" name="roles[]">
        
        @foreach ($roles as $role)
         <option value="{{ $role->id }}"{{ isset($user) ? ($user->roles->pluck('id')->contains($role->id) ? 'selected' :'' ): '' }} >{{ $role->name }}</option>
       
        @endforeach
      </select>
      <!------- error message --------->
      @error('roles')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  </div>
   
  <!------- fin error message --------->
    </div>
  
    {{-- <div class="control-group" id="nugShow">
        <label class="control-label" for="nug">Affecter Region,Resaux </label>
        <div class="controls">
          <select multiple class="form-control span8  @error('nug') is-invalid @enderror " id="nug" name="nugs[]">
            
    
            @foreach ($nugs as $nug)
             <option value="{{ $nug->id }}" {{ isset($user) ? ($user->nugs()->pluck('network_ug_regionmc_id')->contains($nug->id) ? 'selected' :'' ): '' }}  >{{ $nug->regionmc  }} | {{ $nug->ug  }} | {{ $nug->network  }}</option>
    
          @endforeach
            
          </select>
          <!------- error message --------->
          @error('nug')
          <span class="invalid-feedback" nug="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
     
      <!------- fin error message --------->
        </div>
      </div> --}}

      <div class="control-group" id="nugShow">
        <label class="control-label" for="rns">Affecter Region,Resaux </label>
        <div class="controls">
          <select multiple class="form-control span8  @error('rns') is-invalid @enderror " id="rns" name="rns[]">
            <option value="all">All</option>
    
            @foreach ($rns as $rn)
             <option value="{{ $rn->id }}" {{ isset($user) ? ($user->rns()->pluck('regionmc_network_id')->contains($rn->id) ? 'selected' :'' ): '' }}  >{{ $rn->regionmc  }} | {{ $rn->network  }}</option>
    
          @endforeach
            
          </select>
          <!------- error message --------->
          @error('rns')
            <span class="invalid-feedback" rns="alert">
                <strong>{{ $message }}</strong>
            </span>
         @enderror
     
      <!------- fin error message --------->
        </div>
      </div>

      
  <div class="control-group">
    <label class="control-label" for="role">Select Ugs</label>
    <div class="controls">
      <select multiple class="form-control span8 @error('ug') is-invalid @enderror" id="ug" name="ugs[]">
        <option value="all">All</option>
        @foreach ($ugs as $ug)
         <option value="{{ $ug->id }}"{{ isset($user) ? ($user->ugs->pluck('id')->contains($ug->id) ? 'selected' :'' ): '' }} >{{ $ug->designation }}</option>
       
        @endforeach
      </select>
      <!------- error message --------->
      @error('ugs')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
  </div>
   
  <!------- fin error message --------->
    </div>
    
      <div class="control-group">
        <label class="control-label" for="responsable">Responsable</label>
        <div class="controls">
          <select multiple class="form-control span8  @error('responsable') is-invalid @enderror " id="responsable" name="responsable[]">       
            @foreach ($responsables as $responsable)
            {{-- <option value="{{ $responsable->id }}" {{ isset($user) ? ($user->responsables->pluck('id')->contains($responsable->id) ? 'selected' :'' ): '' }}   >{{ $responsable->firstname  }} {{ $responsable->lastname  }} </option> --}}
            <option value="{{ $responsable->id }}" {{ isset($user) ? ($user->userResponsables->pluck('responsable_id')->contains($responsable->id) ? 'selected' :'' ): '' }}  >{{ $responsable->firstname  }} {{ $responsable->lastname  }} </option>
        
         @endforeach
           
          </select>
          <!------- error message --------->
          @error('responsable')
                <span class="invalid-feedback" nug="alert">
                    <strong>{{ $message }}</strong>
                </span>
          @enderror
     
      <!------- fin error message --------->
        </div>
      </div>
    






           
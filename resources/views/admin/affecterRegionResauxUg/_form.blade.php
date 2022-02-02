
  <div class="control-group">
    <label class="control-label" for="regionmc">regionmcss</label>
    <div class="controls">
      <select   class="form-control span8  @error('regionmc') is-invalid @enderror " id="regionmc" name="regionmc">
        
        @foreach ($regionmcs as $regionmc)
         <option value="{{ $regionmc->id }}"  >{{ $regionmc->designation }}</option>
        
        @endforeach
      </select>
      <!------- error message --------->
      @error('regionmc')
      <span class="invalid-feedback" product="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  {{-- {{ isset($network) ? ($network->regionmcs()->pluck('regionmc_id') == $regionmc->id ? 'selected' :'' ): '' }} --}}
  <!------- fin error message --------->
    </div>
  </div>



  <div class="control-group">
    <label class="control-label" for="network">Resaux</label>
    <div class="controls">
      <select multiple="multiple"  class="form-control span8  @error('network') is-invalid @enderror " id="networks" name="networks[]">
        
        @foreach ($networks as $network)
         <option value="{{ $network->id }}"  >{{ $network->designation }}</option>
        @endforeach
      </select>
      <!------- error message --------->
      @error('network')
      <span class="invalid-feedback" network="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  {{-- {{ isset($network) ? ($network->ugs()->pluck('ug_id') == $ug->id ? 'selected' :'' ): '' }}  --}}
  <!------- fin error message --------->
    </div>
  </div>


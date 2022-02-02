<div class="control-group">
    <label for="firstname" class="control-label ">Désignation</label>
    <div class="controls ">
        <input type="text" class="span8 form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
            placeholder="Désignation" value="{{ old('designation', $network->designation ?? null) }}">
        @error('designation')
            <span class="invalid-feedback" product="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="category">Categories</label>
    <div class="controls">
      <select  class="form-control span8  @error('category') is-invalid @enderror " id="category" name="category">
        
        @foreach ($categories as $category)
         <option value="{{ $category->id }}" {{ isset($network) ? ($network->category_id == $category->id ? 'selected' :'' ): '' }} >{{ $category->designation }}</option>
            
        @endforeach
      </select>
      <!------- error message --------->
      @error('category')
      <span class="invalid-feedback" product="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
 
  <!------- fin error message --------->
    </div>
  </div>



<div class="control-group">
    <label class="control-label" for="product">Produits</label>
    <div class="controls">
      <select multiple class="form-control span8  @error('product') is-invalid @enderror " id="product" name="products[]">
        
        @foreach ($products as $product)
         <option value="{{ $product->id }}" {{ isset($network) ? ($network->products->pluck('id')->contains($product->id) ? 'selected' :'' ): '' }} >{{ $product->designation }}</option>
            
        @endforeach
      </select>
      <!------- error message --------->
      @error('product')
      <span class="invalid-feedback" product="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
 
  <!------- fin error message --------->
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="role">Select Plvs</label>
    <div class="controls">
      <select multiple class="form-control span8 @error('plv') is-invalid @enderror" id="plv" name="plvs[]">
        
        @foreach ($plvs as $plv)
         <option value="{{ $plv->id }}"{{ isset($network) ? ($network->plvs->pluck('id')->contains($plv->id) ? 'selected' :'' ): '' }} >{{ $plv->designation }}</option>
       
        @endforeach
      </select>
      <!------- error message --------->
      @error('plvs')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
      @enderror
  </div>

  @if ($errors->any())
  <div class="text-center mt-4">
      @foreach ($errors->all() as $error)
      <p class="alert alert-danger" id="alert">{{ $error }}</p>
      @endforeach
  </div>
  @endif
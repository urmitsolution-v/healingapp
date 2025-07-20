@extends('layout.admin')
@section('content')

<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">हेल्पलाइन नंबर</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">डैशबोर्ड</a></li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST">
                        @csrf
                        <div class="card stretch stretch-full">
                            <div class="card-body row justify-content-center">
                                <label class="form-label text-center mb-3">हेल्पलाइन नंबर और गंतव्य *</label>

                                @php
                                    $helplines = old('helplines', json_decode($setting->value ?? '[]', true));
                                @endphp

                                <div id="helpline-wrapper" class="col-12" data-count="{{ count($helplines) }}">
                                    @forelse($helplines as $index => $data)
                                        <div class="row helpline-item mb-2">
                                            <div class="col-lg-4 mb-1">
                                                <input type="text" name="helplines[{{ $index }}][number]" value="{{ $data['number'] }}" class="form-control @error("helplines.$index.number") is-invalid @enderror" placeholder="मोबाइल नंबर" required>
                                                @error("helplines.$index.number")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 mb-1">
                                                <input type="text" name="helplines[{{ $index }}][destination]" value="{{ $data['destination'] }}" class="form-control @error("helplines.$index.destination") is-invalid @enderror" placeholder="गंतव्य (जैसे: पुलिस)" required>
                                                @error("helplines.$index.destination")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-2 mb-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-danger remove-item">−</button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row helpline-item mb-2">
                                            <div class="col-lg-4 mb-1">
                                                <input type="text" name="helplines[0][number]" class="form-control" placeholder="मोबाइल नंबर" required>
                                            </div>
                                            <div class="col-lg-4 mb-1">
                                                <input type="text" name="helplines[0][destination]" class="form-control" placeholder="गंतव्य (जैसे: पुलिस)" required>
                                            </div>
                                            <div class="col-lg-2 mb-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-danger remove-item">−</button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="col-lg-10 mb-3 text-end">
                                    <button type="button" class="btn btn-success" id="add-more">+ और जोड़ें</button>
                                </div>

                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">सेव करें</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Template --}}
                  <template id="helpline-template">
    <div class="row helpline-item mb-2">
        <div class="col-lg-4 mb-1">
            <input type="text" name="helplines[__index__][number]" class="form-control" placeholder="मोबाइल नंबर" required>
        </div>
        <div class="col-lg-4 mb-1">
            <input type="text" name="helplines[__index__][destination]" class="form-control" placeholder="गंतव्य (जैसे: पुलिस)" required>
        </div>
        <div class="col-lg-2 mb-1 d-flex align-items-center">
            <button type="button" class="btn btn-danger remove-item">−</button>
        </div>
    </div>
</template>


                    {{-- JavaScript --}}
                  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const wrapper = document.getElementById('helpline-wrapper');
        const template = document.getElementById('helpline-template').innerHTML;
        const addBtn = document.getElementById('add-more');

        // Dynamically detect the highest index
        let count = 0;
        wrapper.querySelectorAll('.helpline-item').forEach(item => {
            const input = item.querySelector('input[name^="helplines["]');
            if (input) {
                const match = input.name.match(/helplines\[(\d+)\]/);
                if (match && parseInt(match[1]) >= count) {
                    count = parseInt(match[1]) + 1;
                }
            }
        });

        addBtn.addEventListener('click', function () {
            let newHtml = template.replace(/__index__/g, count);
            wrapper.insertAdjacentHTML('beforeend', newHtml);
            count++;
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.helpline-item').remove();
            }
        });
    });
</script>


                </div>
            </div>
        </div>
    </div>
</main>

@endsection

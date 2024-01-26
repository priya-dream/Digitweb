<form>
    @csrf
    <label for="source">Source:</label>
    <select id="source" name="source">
        @foreach ($sources as $source)
            <option value="{{ $source->source }}">{{ $source->source_name }}</option>
        @endforeach
    </select>

    <label for="sub_source">Sub Source:</label>
    <select id="sub_source" name="sub_source"></select>
</form>
<!-- <button onclick="test()">click</button> -->

<!-- <script src="{{ asset('js/form.js') }}"></script> -->


<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainSelect = document.getElementById('source');
    const subSelect = document.getElementById('sub_source');

    mainSelect.addEventListener('change', function () {
        const sourceId = this.value;

        Fetch districts based on the selected country
        fetch(`/get-districts/${sourceId}`)
            .then(response => response.json())
            .then(data => {
                Clear existing options
               console.log(data);
                subSelect.innerHTML = '';

                // Populate district options
                data.forEach(sub_source => {
                    const option = document.createElement('option');
                    option.value = sub_source.sub_source_id; // Correct property name
                    option.text = sub_source.sub_source_name; // Correct property name
                    subSelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));
    });
});

function test(){
    alert('hi');
}

    </script>
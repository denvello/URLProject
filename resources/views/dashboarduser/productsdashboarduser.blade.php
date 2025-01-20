@extends('myuserdashboard')

@push('styles')
<style>
    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    table th {
        background-color: #f4f4f4;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    table th:hover {
        background-color: #e2e2e2;
    }

    table img {
        width: 50px; /* Thumbnail size */
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    table img:hover {
        transform: scale(1.1);
    }

   </style>
@endpush

@section('contentuser')
<div class="table-wrapper">
    <h2>Daftar Produk User : ({{ $products->total() }})</h2>
    <br>
   
    <table>
        <thead>
            <tr>
                <th onclick="sortTable('id')">Product ID#</th>
                <th onclick="sortTable('product_name')">Product Name</th>
                <th onclick="sortTable('product_description')">Description</th>
                <th>Image1</th>
                <th>Image2</th>
                <th>Image3</th>
                <th>Image4</th>
                <th>Image5</th>
                <th onclick="sortTable('product_price')">Price</th>
                <th onclick="sortTable('product_contact_number')">Contact Number</th>
                <th onclick="sortTable('product_viewed')">Viewed</th>
                <th onclick="sortTable('product_liked')">Liked</th>
                <th onclick="sortTable('product_generated_qr_count')">QR Counted</th>
                <th onclick="sortTable('product_qr_code_scanned')">Scanned</th>
                <th onclick="sortTable('created_at')">Created Date</th>
                <th onclick="sortTable('updated_at')">Updated Date</th>
                <th onclick="sortTable('username')">Username</th>
                <th>Status</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>
                    <a href="javascript:void(0)" onclick="handleCardClick({{ $product->id }}, 'description')" style="text-decoration: none; color: inherit;">
                        {{ strip_tags(Str::limit($product->product_description, 50)) }}
                    </a>
                </td> 
                <td> 
                @if (!empty($product->product_image1_url))
                    <img src="{{ Storage::url($product->product_image1_url) }}" 
                        alt="Product Image" 
                        class="thumbnail-img" 
                        onclick="openModal('{{ Storage::url($product->product_image1_url) }}')">
                @else
                    <img src="{{ asset('/img/no-image-crop.png') }}" 
                        alt="No Image Available" 
                        class="thumbnail-img">
                @endif
                </td>
                <td>
                @if (!empty($product->product_image2_url))
                    <img src="{{ Storage::url($product->product_image2_url) }}" 
                        alt="Product Image" 
                        class="thumbnail-img" 
                        onclick="openModal('{{ Storage::url($product->product_image2_url) }}')">
                @else
                    <img src="{{ asset('/img/no-image-crop.png') }}" 
                        alt="No Image Available" 
                        class="thumbnail-img">
                @endif
                </td>
                <td>
                @if (!empty($product->product_image3_url))
                    <img src="{{ Storage::url($product->product_image3_url) }}" 
                        alt="Product Image" 
                        class="thumbnail-img" 
                        onclick="openModal('{{ Storage::url($product->product_image3_url) }}')">
                @else
                    <img src="{{ asset('/img/no-image-crop.png') }}" 
                        alt="No Image Available" 
                        class="thumbnail-img">
                @endif
                </td>
                <td>
                @if (!empty($product->product_image4_url))
                    <img src="{{ Storage::url($product->product_image4_url) }}" 
                        alt="Product Image" 
                        class="thumbnail-img" 
                        onclick="openModal('{{ Storage::url($product->product_image4_url) }}')">
                @else
                    <img src="{{ asset('/img/no-image-crop.png') }}" 
                        alt="No Image Available" 
                        class="thumbnail-img">
                @endif
                </td>
                <td>
                @if (!empty($product->product_image5_url))
                    <img src="{{ Storage::url($product->product_image5_url) }}" 
                        alt="Product Image" 
                        class="thumbnail-img" 
                        onclick="openModal('{{ Storage::url($product->product_image5_url) }}')">
                @else
                    <img src="{{ asset('/img/no-image-crop.png') }}" 
                        alt="No Image Available" 
                        class="thumbnail-img">
                @endif
                </td>
                <td>Rp {{ number_format($product->product_price, 0, ',', '.') }}</td>
                <td>{{ $product->product_contact_number }}</td>
                <td>{{ $product->product_viewed }}</td>
                <td>{{ $product->product_liked }}</td>
                <td>{{ $product->product_generated_qr_count }}</td>
                <td>{{ $product->product_qr_code_scanned }}</td>
                <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M Y, H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($product->updated_at)->format('d M Y, H:i') }}</td>
                <td>{{ $product->username }}</td>
                <td>
                    <input type="checkbox" 
                           disabled 
                           {{ $product->statusprod == 1 ? 'checked' : '' }}>
                </td>
            </tr>
            <!-- Modal for each product -->
            <div id="description-modal-{{ $product->id }}" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModalF({{ $product->id }})">&times;</span>
                        <h2>{{ $product->product_name }}</h2>
                        <div class="full-description">
                            {{ strip_tags($product->product_description) }}
                        </div>
                        <button class="close-btn" onclick="closeModalF({{ $product->id, 'description' }})">×</button>
                       
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
<br>
    <!-- Pagination -->
    <div class="pagination">
        {{ $products->appends(request()->query())->links() }}
    </div>

<!-- Modal Window -->
<div id="imageModal" class="modal" onclick="closeModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="close-btn" onclick="closeModal()">×</button>
        <img id="modalImage" src="" alt="Modal Image">
    </div>
</div>


<script>
    // Sorting logic
    function sortTable(column) {
        const urlParams = new URLSearchParams(window.location.search);
        const currentDirection = urlParams.get('direction') === 'asc' ? 'desc' : 'asc';
        urlParams.set('sort_by', column);
        urlParams.set('direction', currentDirection);
        window.location.search = urlParams.toString();
    }

function openModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageSrc;
    modal.style.display = 'flex';
}

function closeModal(event) {
    if (!event || event.target === document.getElementById('imageModal')) {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'none';
    }
}

function closeModalF(itemId, type) {
        const modal = document.getElementById(`${type}-modal-${itemId}`);
        if (modal) {
            modal.style.display = 'none';
        }
    }


function handleCardClick(itemId, type) {
        const modal = document.getElementById(`${type}-modal-${itemId}`);
        if (modal) {
            modal.style.display = 'flex';
        }
    }

 // Close the modal when clicking outside
 window.onclick = function (event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    };    

</script>

@endsection

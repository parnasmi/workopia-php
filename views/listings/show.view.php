<?php loadPartial('head'); ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('top-banner'); ?>

<section class="container mx-auto p-4 mt-4">
    <div class="rounded-lg shadow-md bg-white p-3">
        <div class="flex justify-between items-center">
            <a class="block p-4 text-blue-700" href="/listings">
                <i class="fa fa-arrow-alt-circle-left"></i>
                Back To Listings
            </a>
            <div class="flex space-x-4 ml-4">
                <a href="/edit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
                <!-- Delete Form -->
                <form method="POST">
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
                </form>
                <!-- End Delete Form -->
            </div>
        </div>
        <div class="p-4">
            <h2 class="text-xl font-semibold">Software Engineer</h2>
            <p class="text-gray-700 text-lg mt-2">
                We are seeking a skilled software engineer to develop high-quality
                software solutions.
            </p>
            <ul class="my-4 bg-gray-100 p-4">
                <li class="mb-2"><strong>Salary:</strong> $80,000</li>
                <li class="mb-2">
                    <strong>Location:</strong> New York
                    <span
                        class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2">Local</span>
                </li>
                <li class="mb-2">
                    <strong>Tags:</strong> <span>Development</span>,
                    <span>Coding</span>
                </li>
            </ul>
        </div>
    </div>
</section>

<?php loadPartial('bottom-banner'); ?>
<?php loadPartial('footer'); ?>
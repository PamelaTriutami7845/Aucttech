<?php
include 'admin/db_connect.php';
?>
<style>
    #cat-list li {
        cursor: pointer;
    }

    /* #cat-list li:hover {
        color: white;
        background: #007bff8f;
    } */

    .prod-item p {
        margin: unset;
    }

    .bid-tag {
        position: absolute;
        right: .5em;
    }

    .cut-text {
        text-overflow: ellipsis;
        overflow: hidden;
        width: 330px;
        height: 1.2em;
        white-space: nowrap;
    }

    .product {
        display: grid;
        grid-template-columns: repeat(3, 450px);
    }

    @media screen and (max-width: 768px) {
        .product {
            display: grid;
            grid-template-columns: repeat(2, 450px);
        }
    }

    @media screen and (max-width: 600px) {
        .product {
            display: grid;
            grid-template-columns: repeat(1, 450px);

        }

        body {

            width: 452px;

        }
    }
</style>
<?php
$cid = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
?>
<div class="contain-fluid">
    <!-- start slider -->
    <section class="bg-white dark:bg-gray-900" id="1">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">Make your bid!</h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">PT.Bidtech is an online auction company that has a vision to provide a service or place for buying and selling products that can be relied upon by Indonesia..</p>
                <a href="#1" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900 md:">
                    Get started
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="./admin/login.php" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    go to officer
                </a>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/hero/phone-mockup.png" alt="mockup">
            </div>
        </div>
    </section>
    <!-- end slider -->

    <!-- start categori -->
    <div class="categori" id="1">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium justify-evenly" id='cat-list' data-tabs-toggle="#myTabContent" role="tablist">
                <li class='inline-block p-4 border-b-2 rounded-t-lg text-md' data-href="index.php?page=home&category_id=all" id="all">All</li>
                <!-- <li class="mr-2" role="presentation" id="all">
                <button class="inline-block p-4 border-b-2 rounded-t-lg text-xl" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" data-href="index.php?page=home&category_id=all">All</button>
            </li> -->
                <?php
                $cat = $conn->query("SELECT * FROM categories order by name asc");
                while ($row = $cat->fetch_assoc()) :
                    $cat_arr[$row['id']] = $row['name'];
                ?>
                    <li class='inline-block p-4 border-b-2 rounded-t-lg text-md' id='<?php echo $row['id'] ?>' data-href="index.php?page=home&category_id=<?php echo $row['id'] ?>"><?php echo ucwords($row['name']) ?></li>

                <?php endwhile; ?>
            </ul>
        </div>
        <div id="myTabContent" class="product">
            <?php
            $where = "";
            if ($cid > 0) {
                $where  = " and category_id =$cid ";
            }
            $category = $_GET['category_id'] ?? "all";
            $cat = $conn->query("SELECT * FROM products WHERE category_id='$category' order by name asc");
            if ($category == "all") {
                $cat = $conn->query("SELECT * FROM products order by name asc");
            }
            // if ($cat->num_rows) {
            //     echo "<center><h4><i>No Available Product.</i></h4></center>";
            // }
            while ($row = $cat->fetch_assoc()) :
            ?>
                <div class="">
                    <div class="ml-9 w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-3">
                        <a href="#">
                            <img class="p-8 rounded-t-lg" src="admin/assets/uploads/<?php echo $row['img_fname'] ?>" alt="product image" />
                        </a>
                        <div class="px-5 pb-5">
                            <a href="#">
                                <h5 class="cut-text text-xl font-semibold tracking-tight text-gray-900 dark:text-white"> <?php echo $row['name'] ?></h5>
                            </a>
                            <p class="text-sm pt-3">Categori: <?php echo $cat_arr[$row['category_id']] ?></p>
                            <p class="pt-2 pb-2 mb-4 text-base text-neutral-600 dark:text-neutral-200">
                                <?php echo $row['description'] ?>
                            </p>
                            <div class="">
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"><?php echo date("M d,Y h:i A", strtotime($row['bid_end_datetime'])) ?></span>
                            </div>
                            <div class="">
                                <div class="prod_item">
                                    <span class="view_port text-3xl font-bold text-gray-900 dark:text-white">Rp<?php echo number_format($row['start_bid']) ?></span>
                                    <button class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 view_prod" type="button" data-id="<?php echo $row['id'] ?>">View</button>
                                    <!-- <button class="view_prod ">
                                        <a href="#" id="<?php echo $row['id'] ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View Details</a>
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    </div>
</div>
<!-- end categori  -->

<!-- start about -->

<div class="2xl:container 2xl:mx-auto lg:py-16 lg:px-20 md:py-12 md:px-6 py-9 px-4" id="2">
    <div class="flex flex-col lg:flex-row justify-between gap-8">
        <div class="w-full lg:w-5/12 flex flex-col justify-center">
            <h1 class="text-3xl lg:text-4xl font-bold leading-9 text-gray-800 dark:text-white pb-4">About Us</h1>
            <p class="font-normal text-base leading-6 text-gray-600 dark:text-white">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.In the first place we have granted to God, and by this our present charter confirmed for us and our heirs forever that the English Church shall be free, and shall have her rights entire, and her liberties inviolate; and we will that it be thus observed; which is apparent from</p>
        </div>
        <div class="w-full lg:w-8/12">
            <img class="w-full h-full" src="https://i.ibb.co/FhgPJt8/Rectangle-116.png" alt="A group of People" />
        </div>
    </div>

    <div class="flex lg:flex-row flex-col justify-between gap-8 pt-12">
        <div class="w-full lg:w-5/12 flex flex-col justify-center">
            <h1 class="text-3xl lg:text-4xl font-bold leading-9 text-gray-800 dark:text-white pb-4">Our Story</h1>
            <p class="font-normal text-base leading-6 text-gray-600 dark:text-white">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.In the first place we have granted to God, and by this our present charter confirmed for us and our heirs forever that the English Church shall be free, and shall have her rights entire, and her liberties inviolate; and we will that it be thus observed; which is apparent from</p>
        </div>
        <div class="w-full lg:w-8/12 lg:pt-8">
            <div class="grid md:grid-cols-4 sm:grid-cols-2 grid-cols-1 lg:gap-4 shadow-lg rounded-md">
                <div class="p-4 pb-6 flex justify-center flex-col items-center">
                    <img class="md:block hidden" src="https://i.ibb.co/FYTKDG6/Rectangle-118-2.png" alt="Alexa featured Image" />
                    <img class="md:hidden block" src="https://i.ibb.co/zHjXqg4/Rectangle-118.png" alt="Alexa featured Image" />
                    <p class="font-medium text-xl leading-5 text-gray-800 dark:text-white mt-4">Alexa</p>
                </div>
                <div class="p-4 pb-6 flex justify-center flex-col items-center">
                    <img class="md:block hidden" src="https://i.ibb.co/fGmxhVy/Rectangle-119.png" alt="Olivia featured Image" />
                    <img class="md:hidden block" src="https://i.ibb.co/NrWKJ1M/Rectangle-119.png" alt="Olivia featured Image" />
                    <p class="font-medium text-xl leading-5 text-gray-800 dark:text-white mt-4">Olivia</p>
                </div>
                <div class="p-4 pb-6 flex justify-center flex-col items-center">
                    <img class="md:block hidden" src="https://i.ibb.co/Pc6XVVC/Rectangle-120.png" alt="Liam featued Image" />
                    <img class="md:hidden block" src="https://i.ibb.co/C5MMBcs/Rectangle-120.png" alt="Liam featued Image" />
                    <p class="font-medium text-xl leading-5 text-gray-800 dark:text-white mt-4">Liam</p>
                </div>
                <div class="p-4 pb-6 flex justify-center flex-col items-center">
                    <img class="md:block hidden" src="https://i.ibb.co/7nSJPXQ/Rectangle-121.png" alt="Elijah featured image" />
                    <img class="md:hidden block" src="https://i.ibb.co/ThZBWxH/Rectangle-121.png" alt="Elijah featured image" />
                    <p class="font-medium text-xl leading-5 text-gray-800 dark:text-white mt-4">Elijah</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end about -->
</div>


<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
<script>
    $('#cat-list li').click(function() {
        location.href = $(this).attr('data-href')
    })
    $('#cat-list li').each(function() {
        var id = '<?php echo $cid > 0 ? $cid : 'all' ?>';
        if (id == $(this).attr('data-id')) {
            $(this).addClass('active')
        }
    })
    $('.view_prod').click(function() {
        uni_modal_right('View Product', 'view_prod.php?id=' + $(this).attr('data-id'))
    })
</script>
<script>
    const $prevButton = document.getElementById('data-carousel-prev');
    const $nextButton = document.getElementById('data-carousel-next');

    $prevButton.addEventListener('click', () => {
        carousel.prev();
    });

    $nextButton.addEventListener('click', () => {
        carousel.next();
    });
</script>
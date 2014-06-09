<div class="wrap">
    <div class="main-content">
        <h2><span>My Dashboard</span></h2>
        <div class="content-in">
            <form action="">
                <?php
                $this->widget('application.components.ProfileSidebarWidget', array('model' => $userModel));
                ?>

                <div class="center">
                    <?php $this->renderPartial('block_tabs') ;?>
                    <div class="center-in">


                        <!-- <div class="block-pagination">
                            <div class="sort-pagination">
                                <p>Category:</p>
                                <div class="sel-3">
                                    <select class="sel" id="change-category">
                                        <option value="0" >- All -</option>
                                        <option value="1">Topics</option>
                                        <option value="2">Favorites</option>
                                        <option value="3">Comments</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pagination pagination-small">
                                <ul>
                                    <li class="first hidden"><a href="/community">&lt;&lt; First</a></li>
                                    <li class="previous hidden"><a href="/community">&nbsp;</a></li>
                                    <li class="page selected"><a href="/community">1</a></li>
                                    <li class="page"><a href="/community/page/2">2</a></li>
                                    <li class="page"><a href="/community/page/2">3</a></li>
                                    <li class="next"><a href="/community/page/2">&nbsp;</a></li>
                                    <li class="last"><a href="/community/page/2">Last &gt;&gt;</a></li>
                                </ul>
                            </div>
                        </div> -->
                        <div class="block-comment">
                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="block-comment-img">
                                                <div class="photo-avatar">
                                                    <a href="#"><img src="images/photo-avatar-img.png" alt="" /></a>
                                                </div>
                                                <b>Jane S.</b>
                                                <p><span>Santa Monica</span></p>
                                                <p>California</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="block-comment-gray">
                                                <span class="block-comment-arrow"> &nbsp; </span>
                                                <div class="block-comment-center">
                                                    <blockquote>
                                                        <span><a href="#">Jane S.</a> wrote:</span> Tempor incididunt ut labore et dolore magna aliqua. Ut ties stienim andtein minim sesveniam, sesatestes quistees ullamco laboris nisi unite. Unite stess to sesatestes quistees ullam nite stess to sesatestes quistees ullam.
                                                    </blockquote>
                                                </div>
                                                <div class="block-comment-bot">
                                                    <p>Yesterday at 1:34 pm</p>
                                                    <div class="block-comment-bot-in"><img src="images/star-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/share-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/copy-icon.png" alt="" /></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="block-comment">
                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="block-comment-img">
                                                <div class="photo-avatar">
                                                    <a href="#"><img src="images/photo-avatar-img.png" alt="" /></a>
                                                </div>
                                                <b>Jane S.</b>
                                                <p><span>Santa Monica</span></p>
                                                <p>California</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="block-comment-gray">
                                                <span class="block-comment-arrow"> &nbsp; </span>
                                                <div class="block-comment-img-in"><a href="#"><img src="images/block-comment-img.png" alt="" /></a></div>
                                                <div class="block-comment-center">
                                                    <blockquote>
                                                        <span><a href="#">Jane S.</a> wrote:</span> Tempor incididunt ut labore et dolore magna aliqua. Ut ties stienim andtein minim sesveniam, sesatestes quistees ullamco laboris nisi unite. Unite stess to sesatestes quistees ullam nite stess to sesatestes quistees ullam.
                                                    </blockquote>
                                                </div>
                                                <div class="block-comment-bot">
                                                    <p>Yesterday at 1:34 pm</p>
                                                    <div class="block-comment-bot-in"><img src="images/star-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/share-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/copy-icon.png" alt="" /></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="block-comment block-several-comments">
                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="block-comment-img">
                                                <div class="photo-avatar">
                                                    <a href="#"><img src="images/photo-avatar-img.png" alt="" /></a>
                                                </div>
                                                <b>Jane S.</b>
                                                <p><span>Santa Monica</span></p>
                                                <p>California</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="block-comment-gray">
                                                <span class="block-comment-arrow"> &nbsp; </span>
                                                <div class="block-comment-top">
                                                    <p><b><a href="#">Jane S.</a></b> and <a href="#">5 others</a> commented on <strong><a class="" href="#">Top Hiking Places</a></strong></p>
                                                </div>
                                                <div class="block-comment-center">
                                                    <blockquote>
                                                        <span><a href="#">Jane S.</a> wrote:</span> Tempor incididunt ut labore et dolore magna aliqua. Ut ties stienim andtein minim sesveniam, sesatestes quistees ullamco laboris nisi unite. Unite stess to sesatestes quistees ullam nite stess to sesatestes quistees ullam.
                                                    </blockquote>
                                                </div>
                                                <div class="block-comment-bot">
                                                    <p>Yesterday at 1:34 pm</p>
                                                    <div class="block-comment-bot-in"><img src="images/star-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/share-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/copy-icon.png" alt="" /></div>
                                                </div>
                                                <div class="block-comment-center">
                                                    <blockquote>
                                                        <span><a href="#">Jane S.</a> wrote:</span> Tempor incididunt ut labore et dolore magna aliqua. Ut ties stienim andtein minim sesveniam, sesatestes quistees ullamco laboris nisi unite. Unite stess to sesatestes quistees ullam nite stess to sesatestes quistees ullam.
                                                    </blockquote>
                                                </div>
                                                <div class="block-comment-bot">
                                                    <p>Yesterday at 1:34 pm</p>
                                                    <div class="block-comment-bot-in"><img src="images/star-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/share-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/copy-icon.png" alt="" /></div>
                                                </div>
                                                <div class="block-all-commenst-link"><a href="#">See All Comments &gt;</a></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="block-comment">
                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="block-comment-img">
                                                <div class="photo-avatar">
                                                    <a href="#"><img src="images/photo-avatar-img.png" alt="" /></a>
                                                </div>
                                                <b>Jane S.</b>
                                                <p><span>Santa Monica</span></p>
                                                <p>California</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="block-comment-gray">
                                                <span class="block-comment-arrow"> &nbsp; </span>
                                                <div class="block-comment-top">
                                                    <p><b><a href="#">Jane S.</a></b> created the topic <strong><a class="" href="#">Top Hiking Places</a></strong></p>
                                                </div>
                                                <div class="block-comment-center">
                                                    <blockquote>
                                                        <span><a href="#">Jane S.</a> wrote:</span> Tempor incididunt ut labore et dolore magna aliqua. Ut ties stienim andtein minim sesveniam, sesatestes quistees ullamco laboris nisi unite. Unite stess to sesatestes quistees ullam nite stess to sesatestes quistees ullam.
                                                    </blockquote>
                                                </div>
                                                <div class="block-comment-bot">
                                                    <p>Yesterday at 1:34 pm</p>
                                                    <div class="block-comment-bot-in"><img src="images/star-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/share-icon.png" alt="" /></div>
                                                    <div class="block-comment-bot-in"><img src="images/copy-icon.png" alt="" /></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

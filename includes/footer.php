                        </div>
                    </div>
                </div>
            </main>
            
            <a href="#0" class="cd-top">Top</a>

            <script type="text/javascript">
                sr.reveal('.top-nav', {
                    duration: 300,
                    origin:'top'
                });

                $(document).ready(function () {
                        cart_count();
                        function cart_count() {
                            $.ajax({
                                url: '/motojoy/includes/cart_count.php',
                                method: 'POST',
                                data: {cart_count: 1},
                                success: function(data) {
                                    $('.cart_quantity').html(data);
                                }
                            });
                        }
                });
            </script>
        </body>
    </html>

<?php
    /**
     * Class para o envio de emails
     */
    class MailType
    {
        static $_header = '
          <html lang="pt">
                <head>
                  <meta charset="UTF-8">
                  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                  <title>One Letter</title>

                  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

                  <style>
                    .ReadMsgBody {
                      width: 100%;
                      background-color: #ffffff;
                    }

                    .ExternalClass {
                      width: 100%;
                      background-color: #ffffff;
                    }

                    /* Windows Phone Viewport Fix */

                    @-ms-viewport {
                      width: device-width;
                    }
                  </style>

                </head>

                <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="background: #e7e7e7; width: 100%; height: 100%; margin: 0; padding: 0;">
                  <!-- Mail.ru Wrapper -->
                  <div id="mailsub">
                    <!-- Wrapper -->
                    <center class="wrapper" style="table-layout: fixed; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; padding: 0; margin: 0 auto; width: 100%; max-width: 960px;">
                      <!-- Old wrap -->
                      <div class="webkit">
                        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="padding: 0; margin: 0 auto; width: 100%; max-width: 960px;">
                          <tbody>
                            <tr>
                              <td align="center">
                                <!-- Start Section (1 column) -->
                                <table id="intro" cellpadding="0" cellspacing="0" border="0" bgcolor="#4F6331" align="center" style="width: 100%; padding: 0; margin: 0; background-image: url(https://image.ibb.co/kBMU5H/the_tired_motorcycle_4917x2832.jpg); background-size: auto 102%; background-position: center center; background-repeat: no-repeat; background-color: #080e02">
                                  <tbody>
                                    <tr>
                                      <td colspan="3" height="20"></td>
                                    </tr>
                                    <tr>
                                      <td width="330" style="width: 33%;"></td>
                                      <!-- Logo -->
                                      <td width="300" style="width: 30%;" align="center">
                                        <a href="#" target="_blank" border="0" style="border: none; display: block; outline: none; text-decoration: none; line-height: 60px; height: 60px; color: #ffffff; font-family: Verdana, Geneva, sans-serif;  -webkit-text-size-adjust:none;">
                                          <img src="https://image.ibb.co/jpVULH/Motojoy.png" alt="One Letter" width="220"
                                            height="180" border="0" style="border: none; display: block; -ms-interpolation-mode: bicubic;">
                                        </a>
                                      </td>
                                      <!-- Social Button -->
                                      <td width="330" style="width: 33%;" align="right">
                                        <div style="text-align: center; max-width: 150px; width: 100%;">
                                          <span>&nbsp;</span>
                                          <a href="#" target="_blank" border="0" style="border: none; outline: none; text-decoration: none; line-height: 60px; color: #ffffff; font-family: Verdana, Geneva, sans-serif;  -webkit-text-size-adjust:none">
                                            <img src="https://github.com/lime7/responsive-html-template/blob/master/index/f.png?raw=true" alt="facebook.com" border="0"
                                              width="11" height="23" style="border: none; outline: none; -ms-interpolation-mode: bicubic;">
                                          </a>
                                          <span>&nbsp;</span>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="3" height="100"></td>
                                    </tr>
        ';
        static $_footer = '  
        <!-- Icon articles (4 columns) -->
        <table id="icon__article" class="device" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" align="center" style="width: 100%; padding: 0; margin: 0; background-color: #ffffff">
          <tbody>
            <tr>
              <td align="center">
                <div style="display: inline-block;">
                  <table width="240" align="left" cellpadding="0" cellspacing="0" border="0" style="padding: 0; margin: 0; mso-table-lspace:0pt; mso-table-rspace:0pt;"
                    class="article">
                    <tbody>
                      <tr>
                        <td colspan="3" height="40"></td>
                      </tr>
                      <tr>
                        <td width="80" style="width: 8%;"></td>
                        <td align="center">
                          <div class="imgs">
                            <a href="http://127.0.0.1:5500/motojoy/store/" target="_blank" border="0" style="border: none; display: block; outline: none; text-decoration: none; line-height: 60px; height: 60px; color: #ffffff; font-family: Verdana, Geneva, sans-serif; margin: 0 30px; -webkit-text-size-adjust:none;">
                              <img src="https://cdn4.iconfinder.com/data/icons/thefreeforty/30/thefreeforty_shop-128.png" alt="icon" border="0" width="60"
                                height="60" style="border: none; display: block; outline: none; -ms-interpolation-mode: bicubic;">
                            </a>
                          </div>
                          <h3 border="0" style="border: none; line-height: 14px; color: #212121; font-family: Verdana, Geneva, sans-serif; font-size: 16px; text-transform: uppercase; font-weight: normal; overflow: hidden; margin:17px 0 0px 0;">Loja
                          </h3>
                          <p style="line-height: 20px; color: #727272; font-family: Verdana, Geneva, sans-serif; font-size: 16px; text-align: center; overflow: hidden; margin: 10px 0; mso-table-lspace:0;mso-table-rspace:0;">
                          Os melhores produtos na nossa loja!
                          </p>
                        </td>
                        <td width="80" style="width: 8%;"></td>
                      </tr>
                      <tr>
                        <td colspan="3" height="10"></td>
                      </tr>
                      <tr>
                        <td colspan="3" height="5" valign="top" align="center">
                          <img src="https://github.com/lime7/responsive-html-template/blob/master/index/line-2.png?raw=true" alt="line" border="0"
                            width="960" height="5" style="border: none; outline: none; max-width: 960px; width: 100%; -ms-interpolation-mode: bicubic;">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div style="display: inline-block; margin-left: -4px;">
                  <table width="240" align="left" cellpadding="0" cellspacing="0" border="0" style="padding: 0; margin: 0; mso-table-lspace:0pt; mso-table-rspace:0pt;"
                    class="article">
                    <tbody>
                      <tr>
                        <td colspan="3" height="40"></td>
                      </tr>
                      <tr>
                        <td width="80" style="width: 8%;"></td>
                        <td align="center">
                          <div class="imgs">
                            <a href="http://127.0.0.1:5500/motojoy/news" target="_blank" border="0" style="border: none; display: block; outline: none; text-decoration: none; line-height: 60px; height: 60px; color: #ffffff; font-family: Verdana, Geneva, sans-serif; margin: 0 30px; -webkit-text-size-adjust:none;">
                              <img src="https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/news-128.png" alt="icon" border="0" width="60"
                                height="60" style="border: none; display: block; outline: none; -ms-interpolation-mode: bicubic;">
                            </a>
                          </div>
                          <h3 border="0" style="border: none; line-height: 14px; color: #212121; font-family: Verdana, Geneva, sans-serif; font-size: 16px; text-transform: uppercase; font-weight: normal; overflow: hidden; margin:17px 0 0px 0;">Notícias
                          </h3>
                          <p style="line-height: 20px; color: #727272; font-family: Verdana, Geneva, sans-serif; font-size: 16px; text-align: center; overflow: hidden; margin: 10px 0; mso-table-lspace:0;mso-table-rspace:0;">
                          Notícias atualizadas ao minuto!
                          </p>
                        </td>
                        <td width="80" style="width: 8%;"></td>
                      </tr>
                      <tr>
                        <td colspan="3" height="10"></td>
                      </tr>
                      <tr>
                        <td colspan="3" height="5" valign="top" align="center">
                          <img src="https://github.com/lime7/responsive-html-template/blob/master/index/line-2.png?raw=true" alt="line" border="0"
                            width="960" height="5" style="border: none; outline: none; max-width: 960px; width: 100%; -ms-interpolation-mode: bicubic;">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div style="display: inline-block; margin-left: -4px;">
                  <table width="240" align="left" cellpadding="0" cellspacing="0" border="0" style="padding: 0; margin: 0; mso-table-lspace:0pt; mso-table-rspace:0pt;"
                    class="article">
                    <tbody>
                      <tr>
                        <td colspan="3" height="40"></td>
                      </tr>
                      <tr>
                        <td width="80" style="width: 8%;"></td>
                        <td align="center">
                          <div class="imgs">
                            <a href="http://127.0.0.1:5500/motojoy/tipstricks" target="_blank" border="0" style="border: none; display: block; outline: none; text-decoration: none; line-height: 60px; height: 60px; color: #ffffff; font-family: Verdana, Geneva, sans-serif; margin: 0 30px; -webkit-text-size-adjust:none;">
                              <img src="https://cdn2.iconfinder.com/data/icons/thin-line-icons-for-seo-and-development-1/64/SEO_important_note-128.png" alt="icon" border="0" width="60"
                                height="60" style="border: none; display: block; outline: none; -ms-interpolation-mode: bicubic;">
                            </a>
                          </div>
                          <h3 border="0" style="border: none; line-height: 14px; color: #212121; font-family: Verdana, Geneva, sans-serif; font-size: 16px; text-transform: uppercase; font-weight: normal; overflow: hidden; margin:17px 0 0px 0;">Dicas e Truques
                          </h3>
                          <p style="line-height: 20px; color: #727272; font-family: Verdana, Geneva, sans-serif; font-size: 16px; text-align: center; overflow: hidden; margin: 10px 0; mso-table-lspace:0;mso-table-rspace:0;">
                          Aprende a mexer na tua mota connosco!
                          </p>
                        </td>
                        <td width="80" style="width: 8%;"></td>
                      </tr>
                      <tr>
                        <td colspan="3" height="10"></td>
                      </tr>
                      <tr>
                        <td colspan="3" height="5" valign="top" align="center">
                          <img src="https://github.com/lime7/responsive-html-template/blob/master/index/line-2.png?raw=true" alt="line" border="0"
                            width="960" height="5" style="border: none; outline: none; max-width: 960px; width: 100%; -ms-interpolation-mode: bicubic;">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

              </td>
            </tr>
            <tr>
              <td colspan="5" height="40"></td>
            </tr>
          </tbody>
        </table>
        <!-- End Icon articles -->
        
        <!-- Footer -->
        <table id="news__article" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" align="center" style="width: 100%; padding: 0; margin: 0; background-color: #ffffff">
          <tbody>
            <tr>
              <td colspan="3" height="23"></td>
            </tr>
            <tr>
              <td align="center">
                <div border="0" style="border: none; line-height: 14px; color: #727272; font-family: Verdana, Geneva, sans-serif; font-size: 16px;">
                  2018 ©
                  <a href="#" target="_blank" border="0" style="border: none; outline: none; text-decoration: none; line-height: 14px; font-size: 16px; color: #727272; font-family: Verdana, Geneva, sans-serif; -webkit-text-size-adjust:none;">Marco Escaleira</a>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" height="23"></td>
            </tr>
          </tbody>
        </table>
        <!-- End Footer -->
      </td>
    </tr>
  </tbody>
  </table>
  </div>
  <!-- End Old wrap -->
  </center>
  <!-- End Wrapper -->
  </div>
  </body>

  </html>';


        public static function casual($title, $text, $link_text, $link) {
            $mail = '
            <!-- Main Title -->
            <tr>
              <td colspan="3" height="60" align="center">
                <div border="0" style="border: none; line-height: 60px; color: #ffffff; font-family: Verdana, Geneva, sans-serif; font-size: 52px; text-transform: uppercase; font-weight: bolder;">
                  '.$title.'
                </div>
              </td>
            </tr>
            <!-- Line 1 -->
            <tr>
              <td colspan="3" height="20" valign="bottom" align="center">
                <img src="https://github.com/lime7/responsive-html-template/blob/master/index/line-1.png?raw=true" alt="line" border="0"
                  width="464" height="5" style="border: none; outline: none; max-width: 464px; width: 100%; -ms-interpolation-mode: bicubic;">
              </td>
            </tr>
            <!-- Meta title -->
            <tr>
              <td colspan="3">
                <table cellpadding="0" cellspacing="0" border="0" align="center" style="padding: 0; margin: 0; width: 100%;">
                  <tbody>
                    <tr>
                      <td width="90" style="width: 9%;"></td>
                      <td align="center">
                        <div border="0" style="border: none; height: 60px;">
                          <p style="font-size: 18px; line-height: 24px; font-family: Verdana, Geneva, sans-serif; color: #ffffff; text-align: center; mso-table-lspace:0;mso-table-rspace:0;">
                            '.$text.'
                          </p>
                        </div>
                      </td>
                      <td width="90" style="width: 9%;"></td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="3" height="160"></td>
            </tr>
            <tr>
              <td width="330"></td>
              <!-- Button Start -->
              <td width="300" align="center" height="52">
                <div style="background-image: url(https://github.com/lime7/responsive-html-template/blob/master/index/intro__btn.png?raw=true); background-size: 100% 100%; background-position: center center; width: 225px;">
                  <a href="'.$link.'" target="_blank" width="160" height="52" border="0" bgcolor="#009789" style="border: none; outline: none; display: block; width:160px; height: 52px; text-transform: uppercase; text-decoration: none; font-size: 17px; line-height: 52px; color: #ffffff; font-family: Verdana, Geneva, sans-serif; text-align: center; background-color: #009789;  -webkit-text-size-adjust:none;">
                    '.$link_text.'
                  </a>
                </div>
              </td>
              <td width="330"></td>
            </tr>
            <tr>
              <td colspan="3" height="85"></td>
            </tr>
          </tbody>
        </table>
        <!-- End Start Section -->

            ';

            return self::$_header . $mail . self::$_footer;
        }

        public static function contact($message, $username, $email) {
          $send = "Mensagem de: \r\n $username - $email \r\n<br><br> $message";
          return $send;
        }
    }
?>
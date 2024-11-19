<div class="app-drawer-wrapper right-sidebar">
    <div class="drawer-nav-btn">
        <button type="button" class="hamburger hamburger--elastic is-active close_server_status_btn">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
    </div>
    <div class="drawer-content-wrapper">
        <div class="scrollbar-container">
            <h3 class="drawer-heading"><?php echo app_lang('server_status'); ?></h3>
            <div class="drawer-section">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="mb-0 table table-hover" id="system-info">
                                <thead>
                                    <tr>
                                        <th class="right-sidebar-th"><?php echo app_lang('variable_name'); ?></th>
                                        <th><?php echo app_lang('server_info_value'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('os'); ?></td>
                                        <td>
                                            <?php
                                            echo php_uname('v');
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('webserver'); ?></td>
                                        <td>
                                            <?php
                                            echo $_SERVER['SERVER_SOFTWARE'] ?? 'N/A';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('webserver_user'); ?></td>
                                        <td>
                                            <?php
                                            echo get_current_user();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('server_protocol'); ?></td>
                                        <td>
                                            <?php
                                            echo $_SERVER['SERVER_PROTOCOL'] ?? 'N/A';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('php_version'); ?></td>
                                        <td>
                                            <?php
                                            echo \PHP_VERSION;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('php_extension_curl'); ?></td>
                                        <td>
                                            <?php
                                            if (!extension_loaded('curl')) {
                                                echo "<span class='text-danger'>Not enabled</span>";
                                            } else {
                                                $curlVersion = curl_version();
                                                echo "<span class='text-success'>Enabled (Version: ".$curlVersion['version'].')</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('php_extension_mbstring'); ?></td>
                                        <td>
                                            <?php
                                            if (!extension_loaded('mbstring')) {
                                                echo "<span class='text-danger'>Not enabled</span>";
                                            } else {
                                                $curlVersion = curl_version();
                                                echo "<span class='text-success'>Enabled (Version: ".$curlVersion['version'].')</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('php_extension_intl'); ?></td>
                                        <td>
                                            <?php
                                            if (!extension_loaded('intl')) {
                                                echo "<span class='text-danger'>Not enabled</span>";
                                            } else {
                                                $curlVersion = curl_version();
                                                echo "<span class='text-success'>Enabled (Version: ".$curlVersion['version'].')</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('php_extension_json'); ?></td>
                                        <td>
                                            <?php
                                            if (!extension_loaded('json')) {
                                                echo "<span class='text-danger'>Not enabled</span>";
                                            } else {
                                                $curlVersion = curl_version();
                                                echo "<span class='text-success'>Enabled (Version: ".$curlVersion['version'].')</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('php_extension_mysqlnd'); ?></td>
                                        <td>
                                            <?php
                                            if (!extension_loaded('mysqlnd')) {
                                                echo "<span class='text-danger'>Not enabled</span>";
                                            } else {
                                                $curlVersion = curl_version();
                                                echo "<span class='text-success'>Enabled (Version: ".$curlVersion['version'].')</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('php_extension_xml'); ?></td>
                                        <td>
                                            <?php
                                            if (!extension_loaded('xml')) {
                                                echo "<span class='text-danger'>Not enabled</span>";
                                            } else {
                                                $curlVersion = curl_version();
                                                echo "<span class='text-success'>Enabled (Version: ".$curlVersion['version'].')</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('php_extension_gd'); ?></td>
                                        <td>
                                            <?php
                                            if (!extension_loaded('gd')) {
                                                echo "<span class='text-danger'>Not enabled</span>";
                                            } else {
                                                $curlVersion = curl_version();
                                                echo "<span class='text-success'>Enabled (Version: ".$curlVersion['version'].')</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('mysql_version'); ?></td>
                                        <td>
                                            <?php
                                            echo db_connect()->query('SELECT VERSION() as version')->getRow()->version;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('mysql_max_allowed_connections'); ?></td>
                                        <td>
                                            <?php
                                            echo db_connect()->query("SHOW VARIABLES LIKE 'max_connections'")->getRow()->Value;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('maximum_packet_size'); ?></td>
                                        <td>
                                            <?php
                                            echo bytesToSize('', db_connect()->query("SHOW VARIABLES LIKE 'max_allowed_packet'")->getRow()->Value);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('sql_mode'); ?></td>
                                        <td>
                                            <?php
                                            echo db_connect()->query('SELECT @@sql_mode as mode')->getRow()->mode;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('max_input_vars'); ?></td>
                                        <td>
                                            <?php
                                            $max_input_vars = ini_get('max_input_vars');
                                            echo $max_input_vars ? $max_input_vars : 'N/A';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('upload_max_filesize'); ?></td>
                                        <td>
                                            <?php
                                            $upload_max_filesize = ini_get('upload_max_filesize');
                                            echo $upload_max_filesize ? $upload_max_filesize : 'N/A';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('post_max_size'); ?></td>
                                        <td>
                                            <?php
                                            $post_max_size = ini_get('post_max_size');
                                            echo $post_max_size ? $post_max_size : 'N/A';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('max_execution_time'); ?></td>
                                        <td>
                                            <?php
                                            $execution_time = ini_get('max_execution_time');
                                            echo $execution_time ? $execution_time : 'N/A';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('memory_limit'); ?></td>
                                        <td>
                                            <?php
                                            $memory = ini_get('memory_limit');
                                            echo $memory ? $memory : 'N/A';
                                            if ((float) $memory < 128 && (float) $memory > -1) {
                                                echo '<br /><span class="text-warning">128M is recommended value (or bigger)</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('environment'); ?></td>
                                        <td>
                                            <?php
                                            echo ucfirst(ENVIRONMENT);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('installation_path'); ?></td>
                                        <td>
                                            <?php
                                                echo FCPATH;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold"><?php echo app_lang('base_url'); ?></td>
                                        <td>
                                            <?php
                                                echo base_url();
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
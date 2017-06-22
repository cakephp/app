# Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
#
# Licensed under The MIT License
# For full copyright and license information, please see the LICENSE.txt
# Redistributions of files must retain the above copyright notice.
# MIT License (https://opensource.org/licenses/mit-license.php)

CREATE TABLE sessions (
  id char(40) NOT NULL,
  data text,
  expires INT(11) NOT NULL,
  PRIMARY KEY  (id)
);

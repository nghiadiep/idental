#!/usr/bin/perl
#----------------------------------------------------------------
# ��L�̐ݒ���m�F���ĉ������B�i/�Ȃǔ������Ȃ��ŉ������B�j
# ���Ȃ��̎؂�Ă���T�[�o�[��CGI�ē��ɕK������������܂�
#----------------------------------------------------------------
# �I�[�g���X�|���_�[�v���O����
# ���̃X�N���v�g�̖��f�z�z�͋֎~�������܂��B
# ������ЃL�[���[�h�}�[�P�e�B���O������
# info@niche-marketing.jp
# http://www.niche-marketing.jp/
# ===============================================================================
# �����ݒ�
# ===============================================================================
# ���{��R�[�h���C�u����
require './jcode.pl';

# �Z�b�g�A�b�v�t�@�C��
require './set.pl';

# ===============================================================================
# �����ݒ肱���܂�
# ===============================================================================

# ���t���擾
# $date_now�ɂ͒�^�����ꂽ���t�\����
# $data_num�ɂ͓��t���瓾���鐔�l���i�[�����
# (2000�N���Ή�)
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time + ($time_diff * 3600));
if ($year > 50) {$year += 1900 ;} else{$year += 2000 ;}
@wday_array = ('��','��','��','��','��','��','�y');
$date_now = sprintf("%04d�N%02d��%02d���i%s�j%02d��%02d��%02d�b",$year,$mon +1,$mday,$wday_array[$wday],$hour,$min,$sec);
#$date_num = sprintf("%04d%02d%02d%02d%02d%02d",$year,$mon +1,$mday,$hour,$min,$sec);
$date_num = sprintf("d%d%02d%02d%02d",$mon +1,$mday,$hour,$min,$sec);

# �����[�g�z�X�g���擾
$addr = $ENV{'REMOTE_ADDR'};
$host = $ENV{'REMOTE_HOST'};
if ($host eq $addr) { $host = gethostbyaddr(pack('C4',split(/\./,$host)),2) || $addr; }

# �t�H�[������̃f�[�^���擾

if ($ENV{'REQUEST_METHOD'} eq "POST") { read(STDIN,$buffer,$ENV{'CONTENT_LENGTH'}); }
else { $buffer = $ENV{'QUERY_STRING'}; }

if ($buffer eq "") { &error('�G���[','�g�������Ԉ���Ă��܂�.'); }
@pairs = split(/&/,$buffer);

# �t�H�[������̃f�[�^��A�z�z��Ɋi�[
foreach $pair (@pairs)
{
    ($name, $value) = split(/=/, $pair);
    $name =~ tr/+/ /;
    $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

#-----[ sylph+ ���p�J�^�J�i��S�p�� ]
&jcode'h2z_sjis(*name);
&jcode'h2z_sjis(*value);
#

    &jcode'convert(*name,'sjis');
    &jcode'convert(*value,'sjis');

    # ���̓f�[�^�̃`�F�b�N
    # �^�O�����͂���Ă���΁A����𖳌��ɂ���B&lt�Ȃǂɒu�������\�����Ă�
    $value =~ s/</&lt;/g;
    $value =~ s/>/&gt;/g;
    # ��؂蕶���́h,�h������΁h�C�h�ɕϊ�
    $value =~ s/\,/�C/g;
    # ���s�R�[�h��<br>�ɕϊ�(�ォ��Win�AMac�AUnix�p�̏���)
    $value =~ s/\r\n/<br>/g;
    $value =~ s/\r/<br>/g;
    $value =~ s/\n/<br>/g;

    if ($name =~ /^email/i || $name =~ /^e\-mail/i) {

            $value =~ s/�@/ /g;
            if ($value =~ / / || $value =~ /;/) { $value = ""; }
            if (!($value =~ /(.*)\@(.*)\.(.*)/)) { $value = ""; }

            $email = $value;
        }

    # �A�z�z��Ɋi�[
    $FORM{$name} = $value;
    $FORM{$value} = $name;

    push ( @data_n, $name);
    push ( @data_v, $value);

}

if ( $FORM{'mode'} eq 'view' ) { &view;}
if ( $FORM{'mode'} eq 'sendmail' ) { &sendmail;}
if ( $FORM{'mode'} eq 'admin' ) { &admin;}
if ( $FORM{'mode'} eq 'admin_2' ) { &admin_2;}
if ( $FORM{'mode'} eq 'ad_regist_1') { &ad_regist_1; }
if ( $FORM{'mode'} eq 'mail_edit_1') { &mail_edit_1; }
if ( $FORM{'mode'} eq 'ad_edit_1') { &ad_edit_1; }
if ( $FORM{'mode'} eq 'ad_del_1') { &ad_del_1; }
if ( $FORM{'mode'} eq 'mail_edit_regist') { &mail_edit_regist; }
if ( $FORM{'mode'} eq 'mail_edit_view') { &mail_edit_view; }
if ( $FORM{'mode'} eq 'mail_edit_view') { &error('�G���[','���ڋN���͂ł��܂���');}


# ���M�m�F��� ===================================================================

sub view {

    $file_honbun = "$dir3/$FORM{'id'}.cgi";
    open (IN,"$file_honbun") || &error('�I�[�v���G���[','�{���ݒ肪����Ă��܂���B');
    @LINES = <IN>;
    close (IN);
        ($subject,$up,$down,$syomei) = split(/\,/, $LINES[0]);

    $file_settei = "$dir3/$FORM{'id'}_2.cgi";
    open (IN,"$file_settei") || &error('�I�[�v���G���[','���M�ݒ肪����Ă��܂���B');
    @LINES_2 = <IN>;
    close (IN);
    ($ad_email,$ad_view,$ad_ref,$ad_hissu) = split(/\,/, $LINES_2[0]);

    $tmp_id = $FORM{'id'};
    $template = "$tmp_dir/$ad_view";
    open (IN,"$template") || &error('�I�[�v���G���[',"�e���v���[�g�t�@�C�����J���܂���B");
    @LINES_TMP = <IN>;
    close (IN);

    print "Content-type: text/html\n\n";
    foreach ( @LINES_TMP ) {
        if ( $_ =~ /\$start\$/ ) {
            print "<form method=post action=form.cgi>\n";
            print "  <input type=hidden name=mode value=sendmail>\n";
            print "  <input type=hidden name=id value=$FORM{'id'}>\n";
            print "  <input type=hidden name=subject value=$subject>\n";
            print "  <input type=hidden name=ad_ref value=\"$ad_ref\">\n";
            print "  <table border=0 cellpadding=0 align=center cellspacing=0 bgcolor=$color1>\n";
            print "    <tr>\n";
            print "      <td>\n";
            print "        <table border=0 width=100% cellpadding=5 cellspacing=1 cellpadding=3>\n";
            print "          <tr bgcolor=$color2><td><b>����</b></td><td><b>���e</b></td></tr>\n";

            $count_name = @data_n;
            foreach $num ( 0.. $count_name-3 ) {
                print "<tr><td nowrap bgcolor=$color2><input type=hidden name=$data_n[$num] value=\"$data_v[$num]\">$data_n[$num]</td><td bgcolor=$color3>$data_v[$num]</td></tr>\n";
            }
            print "</table></td></tr></table><p>\n";
            print "<table border=0 cellpadding=0 align=center width=95% cellspacing=0 bgcolor=$color1><tr><td>\n";
            print "<table border=0 width=100% cellpadding=3 cellspacing=1 cellpadding=3>\n";
            print "<tr bgcolor=$color2>\n";

            # �K�{���ڏ���================================
#-----[ sylph+ �K�{���ڏ����̃o�O�t�B�N�X1 ]
            $ad_hissu =~ s/\n$//;
#

            (@hissu_2) = split ( /\:/,$ad_hissu);
            foreach ( @hissu_2 ) {

#-----[ sylph+ �K�{���ڏ����̃o�O�t�B�N�X2 ]
#               if ( $data_v[$_] eq "" ) {
               if ( $FORM{$_} eq "" ) {
#
                    push ( @hissu_3,$_);
                }
            }

#            @hissu_2 = split ( /\:/,$ad_hissu);
#                foreach $num ( @hissu_2 ) {
#                if ( $data_v[$num] eq "" ) {
#                    push ( @hissu_3,$num);
#                }
#            }
            $count_hissu = @hissu_3;
            if ( $count_hissu == 0 ) {
                print "<td align=center><input type=submit value=���M></td>\n";
            } else {
                print "<td>\n";
                foreach $num ( @hissu_3 ) {
#-----[ sylph+ �K�{���ڏ����̃o�O�t�B�N�X3 ]
#                    print "�u$data_n[$num]�v\n";
                    print "�u$num�v\n";
#

                }
                print "�����͂���Ă��Ȃ��̂Ť���M�ł��܂���B</td>\n";
            }
            print "</tr></table></td></tr></table></form>\n";
        } else {
            print "$_\n";
        }
    }
exit;
}

# ���[�����M======================================================================

sub sendmail {

#-----[ sylph+ ���e���擾���� ]
local(@log) = ($addr,$FORM{'id'},$FORM{'subject'});
local(@data_s) = ();
$count = @data_n;
foreach (4..$count-1) {
    push(@log,"$data_n[$_]$log_dat$data_v[$_]");
         $data_v[$_] =~ s/&lt;br&gt;/\n/g;
    if ($data_v[$_] =~ /\n/) { &jis("$data_n[$_] =\n\n$data_v[$_]\n"); push(@data_s,"$msg\n"); }
    else { &jis("$data_n[$_] = $data_v[$_]"); push(@data_s,"$msg\n"); }
}
#
#-----[ sylph+ ��d���e�h�~�@�\(IP+���e+���Ԕ͈�) ]
$logcount = "$dir4\/$FORM{'id'}_count.log";
if (!-e "$logcount") { $logno = 1; }
else {
    open(IN,"$logcount") || &error('�V�X�e���ُ� 101','�\���󂠂�܂��񂪉��炩�̌����ŏ����ł��܂���.');
    $logno = <IN>;
    close(IN);
    chop($logno);
}
#
#-----[ sylph+ ���O�Ɣ�r���� ]
local($down_c) = $logno;
local($time_c,$date_c,$line) = "";
local($flag_eq) = 0;
local(@Check_new,@Ceck_old);
foreach (1 .. $logno) {
    $logfile = "$dir4\/$FORM{'id'}_$down_c\.log";
    if (-e $logfile) {
        open(IN,"$logfile") || &error('�V�X�e���ُ� 107','�\���󂠂�܂��񂪉��炩�̌����ŏ����ł��܂���.');
        @lines = <IN>;
        close(IN);
        foreach $line (@lines) {
            @Check_old = ();
            @Check_new = @log;
            chop($line);
            ($time_c,$date_c,@Check_old) = split(/$log_csv/, $line);
            unshift(@Check_new,$time_c,$date_c);
            ($log_get) = join($log_csv,@Check_new);
            if (time - $time_c > $time_check) {
                $flag_eq = 1;
                last;
            }
            if ($line eq $log_get){
                &error('��d���e','��d���e�́A�ł��Ȃ��悤�ɂȂ��Ă���܂��B');
            }
        }
        if ($flag_eq) { last; }
        if ($down_c > 1) { $down_c--; }
    }
}
#
#-----[ sylph+ ���O�ۑ��`���֕ϊ����� ]
unshift(@log,time,$date_now);
local($log_send) = join($log_csv,@log);
#
#-----[ sylph+ ���b�N�J�n���� ]
&lock_d;
#

    $file_settei = "$dir3/$FORM{'id'}_2.cgi";
    open (IN,"$file_settei") || &error('�I�[�v���G���[','���M�ݒ�t�@�C�����J���܂���B');
    @LINES = <IN>;
    close (IN);
    ($ad_email,$ad_view,$ad_ref,$ad_hissu) = split(/\,/, $LINES[0]);

    $file_honbun = "$dir3/$FORM{'id'}.cgi";
    open (IN,"$file_honbun") || &error('�I�[�v���G���[','�Ȃ����w�肳�ꂽ�����݃t�@�C�����J���܂���B');
    @LINES = <IN>;
    close (IN);
    ($subject,$up,$down,$syomei) = split(/\,/, $LINES[0]);

    if (!(open(OUT,"| $sendmail -t"))) { &error('�V�X�e���ُ�','�\���󂠂�܂��񂪉��炩�̌����ŏ����ł��܂���.'); }
        $ad_email =~ s/\:/\,/g;
           print OUT "Errors-To: $mailto\n";
        print OUT "To: $email\n";
        print OUT "Bcc: $ad_email\n";
        print OUT "From: $ad_email\n";

    &jis("Subject: $FORM{'subject'}"); print OUT "$msg\n";
    print OUT "Content-Transfer-Encoding: 7bit\n";
    print OUT "Content-Type: text/plain\; charset=\"ISO-2022-JP\"\n\n";

    $up =~ s/<br>/\n/g;
    $down =~ s/<br>/\n/g;
    $syomei =~ s/<br>/\n/g;
    &jis("=================================================="); print OUT "$msg\n";
    &jis("$FORM{'subject'}"); print OUT "$msg\n";
    &jis("=================================================="); print OUT "$msg\n";
    &jis("\[���M����\] $date_now"); print OUT "$msg\n";
    &jis("--------------------------------------------------"); print OUT "$msg\n";
    &jis("$up"); print OUT "$msg\n";
    &jis("--------------------------------------------------"); print OUT "$msg\n";
    &jis("���M���e"); print OUT "$msg\n";
    &jis("--------------------------------------------------"); print OUT "$msg\n\n";

#-----[ sylph+ ���e�̑��M ]
print OUT "@data_s\n";
#

#    $count = @data_n;
#    foreach (4..$count-1) {
#
#        $data_v[$_] =~ s/&lt;br&gt;/\n/g;
#        if ($data_v[$_] =~ /\n/) { &jis("$data_n[$_] =\n\n$data_v[$_]\n"); print OUT "$msg\n"; }
#        else { &jis("$data_n[$_] = $data_v[$_]"); print OUT "$msg\n"; }
#    }
    &jis("--------------------------------------------------"); print OUT "$msg\n\n";
    &jis("$down"); print OUT "$msg\n";
    &jis("$syomei"); print OUT "$msg\n";

    close (OUT);

#-----[ sylph+ �f�[�^�ۑ� ]
$logfile = "$dir4\/$FORM{'id'}_$logno\.log";
if (!-e $logfile) {
    $logno = 1;
    $logfile = "$dir4\/$FORM{'id'}_$logno\.log";
}
else {
    open(IN,"$logfile") || &error('�V�X�e���ُ� 102','�\���󂠂�܂��񂪉��炩�̌����ŏ����ł��܂���.');
    @lines = <IN>;
    close(IN);
}
if ($log_max <= @lines) {
    @lines = ();
    do {
        $logno++;
        $logfile = "$dir4\/$FORM{'id'}_$logno\.log";
    } while (-e $logfile);
}
unshift(@lines,"$log_send\n");

open(OUT,"> $logfile") || &error('�V�X�e���ُ� 103','�\���󂠂�܂��񂪉��炩�̌����ŏ����ł��܂���.');
print OUT @lines;
close(OUT);
chmod(0600,"$logfile");
open(OUT,"> $logcount") || &error('�V�X�e���ُ� 104','�\���󂠂�܂��񂪉��炩�̌����ŏ����ł��܂���.');
print OUT "$logno\n";
close(OUT);
chmod(0600,"$logcount");

&unlock_d;
#

    print "Location: $ad_ref\n\n"; 
}

# ���[���̕����R�[�h��JIS�`���ɕϊ�==========================================

sub jis { $msg = $_[0]; &jcode'convert(*msg, 'jis'); }


# ===================================================================================
# �X�^�C���V�[�g�̒�`
sub style {

print <<"EOF";

<STYLE TYPE="text/css">
<!--
//
a:link    {font-size: $font_size; text-decoration:none; color:$link_0 ;}
a:visited {font-size: $font_size; text-decoration:none; color:$link_0 ;}
a:active  {font-size: $font_size; text-decoration:none; color:$link_0 ;}
a:hover   {font-size: $font_size; text-decoration:underline; color:$link_1 ;}
td        {font-size: $font_size;}
b         {font-size: $font_size;}
big       {font-size: 15pt;}
span      {font-size: $font_size;line-height:12pt;}
-->
</STYLE>

EOF

}

# �w�b�_�\��
sub html_header {

print <<"EOF";
   <center>
   <img src="./images/header.gif" border="0">
EOF

}

# �t�b�^�\��
sub html_footer {

print <<"EOF";
   <img src="./images/footer.gif" border="0">
   </center>
EOF

}

# �G���[����=================================================================

sub error {
#-----[ sylph+ �A�����b�N ]
&unlock_d;
#

    print "Content-type: text/html\n\n";
    print "<html><head><title>$main_title</title>\n";
    print <<"EOF";
    </head>
    $body
EOF
#    &html_header;
    print <<"EOF";
    <br>
    <p>
      <table border=0 cellpadding=0 align=center width=600 cellspacing=0 bgcolor=$color1>
        <tr>
          <td>
            <table border=0 width=100% cellpadding=3 cellspacing=1 cellpadding=3>
              <tr>
                <td align=center bgcolor=$color2 height=30><font color=red><b>$_[0]</b></font></td>
              </tr>
              <tr>
                <td align=center bgcolor=$color3 height=30><font color=red>$_[1]</font></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    <p>
EOF
#    &html_footer;
    print <<"EOF";
    </body></html>
EOF

exit;
}


sub admin {

    print "Content-type: text/html\n\n";
    print "<html><head><title>$main_title</title>\n";
    &style;
    print "<META content=\"text/html; charset=Shift_JIS\" http-equiv=Content-Type>\n";
    print "<META content=\"text/css\" http-equiv=Content-Style-Type>\n";
    print <<"EOF";
    </head>
    $body
EOF
    &html_header;
    print <<"EOF";
      <table cellpadding="5" cellspacing="0" width="720">
        <tr>
          <td>
            <br><br>
            <form method=post action=form.cgi>
              <table align=center bgcolor=#000000 border=0 cellpadding=0 cellspacing=0>
                <tr>
                  <td>
                    <table border=0 cellpadding=3 cellspacing=1 height=197>
                      <tr bgcolor=#ccffcc align=center>
                        <td height="28" width="532">
                          <b><font size=4>�Ǘ���ʁ@�p�X���[�h����</font></b>
                        </td>
                      </tr>
                      <tr bgcolor=$color3 align=center>
                        <td height="97" width="532">
                          <input name="mode" value="admin_2" type="hidden">
                          <input name="pass" size="24" type="password">
                          <input value="�p�X���[�h����" type="submit" onclick="window.open('main.html', '_self');">
                        </td>
                      </tr>
                      <tr align=center>
                        <td bgcolor="#ffffff" height="46" style="font-size: 13px;">�@��L���ɐݒ莞�̃p�X���[�h�������͉������B</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
      </table>

EOF
    &html_footer;
    print <<"EOF";
    </body></html>
EOF

}

sub admin_2 {

    if ( $_[0] eq '' ) {
        if ( $FORM{'pass'} ne $pass ) { &error ('�G���[','�p�X���[�h�̔F�؂��ł��܂���B'); }
    }
    
    print "Content-type: text/html\n\n";
    print "<html><head><title>$main_title</title>\n";
    print "<META content=\"text/html; charset=Shift_JIS\" http-equiv=Content-Type>\n";
    print "<META content=text/css http-equiv=Content-Style-Type>\n";
    print "</head>$body\n" ;
    &html_header;

    $ad_file_1 = "$dir3/data.cgi";

    open (IN,"$ad_file_1") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
    @LINES_AD_1 = <IN>;
    close (IN);
    $count_ad_file_1 = @LINES_AD_1;

    print <<"EOF";
    <table cellpadding="5" cellspacing="0" width="720">
      <tr>
        <td>
          <br>
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
            <tr>
              <td>
                <b><font color="#000000" size="4">�V�K�o�^</font></b>
              </td>
            </tr>
          </table>
          <br>
          <form method="post" action="form.cgi">
            <input type=hidden name=mode value=ad_regist_1>
            <table align="center" bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" width="600">
              <tr>
                <td>
                  <table border="0" cellpadding="8" cellspacing="1" width="100%">
                    <tr bgcolor="#ccffcc">
                      <td align="center">
                        <b><font color="#000000" size="3">���[��ID</font></b>
                      </td>
                      <td align="center">
                        <b><font color="#000000" size="3">�^�C�g���i���̃��[����������悤�Ȑ������j</font></b>
                      </td>
                    </tr>
                    <tr bgcolor="#ffffff">
                      <td>
EOF
    print "<select name=g_id_1>\n";
    $count_ryouiki = @id_array_1;
    foreach ( 0.. $count_ryouiki -1) {
        print "<option value=$id_array_2[$_]>$id_array_1[$_]</option>\n" ;
    }
    print "</select>\n";
    print "<select name=g_id_2>\n";
    foreach ( @id_array_3) {
        print "<option value=$_>$_</option>\n" ;
    }
    print "</select>\n";

    print <<"EOF";
                      </td>
                      <td>
                        <input type=text name=g_naiyou size=75>
                      </td>
                    </tr>
                    <tr bgcolor=#ccffcc>
                      <td colspan=2 align=center>
                        <input type=submit value=�V�K�o�^>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </form>
          <table align="center" bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" width="600">
            <tr>
              <td>
                <table border="0" cellpadding="8" cellspacing="1" width="100%">
                  <tr bgcolor="#ccffcc">
                    <td align="center">
                      <font color="#000000"><b><font size="3">ID�Ή��\\</font></b></font>
                    </td>
                  </tr>
                  <tr bgcolor="#ffffff">
                    <td align="center">
EOF

    foreach ( 0..$count_ryouiki -1) {
        print "\<font size=2>��[$id_array_1[$_] \= <font color=red>$id_array_2[$_]</font>\]</font><br>\n";
    }
    print "</td></tr></table></td></tr></table>\n";
    print "<hr noshad size=1 width=600>\n" ;
    print "<table align=center border=0 cellpadding=0 cellspacing=0 width=600>\n";
    print "<tr><td><b><font color=#000000 size=3>�ҏW</font></b></td></tr></table>\n";

    if (!-e $ad_file_1) { 
        print "\n";
    } else {

        print "<br>\n";

        foreach (@LINES_AD_1){
            ($data_id,$g_id_1,$g_id_2,$g_naiyou) = split (/\,/,$_);

            print <<"EOF";
          <table border=0 cellpadding=0 align=center cellspacing=0 bgcolor=$color1 width=600>
            <tr>
              <td>
                <table border=0 width=100% cellpadding=8 cellspacing=1>
                  <tr bgcolor=#ccffcc>
                    <td align=center><b><font color=#000000 size=3>No.</font></b></td>
                    <td align=center><b><font color=#000000 size=3>���[��ID</font></b></td>
                    <td align=center><b><font color=#000000 size=3>�^�C�g���i���̃��[����������悤�Ȑ������j</font></b></td>
                    <td align=center colspan=2><b><font color=#000000 size=3>���s���e</font></b></td>
                 </tr>
                 <tr bgcolor=#ffffff>
                   <td align=center>$data_id</td>
                   <td align=center>
EOF
            print "$g_id_1-$g_id_2</td>\n";
            print "<td>\n";
            print "<form method=post action=form.cgi>\n";
            print "<input type=hidden name=data_id value=$data_id>\n";
            print "<input type=hidden name=g_id_1 value=$g_id_1><input type=hidden name=g_id_2 value=$g_id_2>\n";
            print "<input type=text name=g_naiyou size=50 value=$g_naiyou>\n" ;
            print "<input type=hidden name=mode value=ad_edit_1>\n";
            print "<input value=�ύX type=submit>\n";
            print "</form>\n";
            print "</td>\n";
            print "<td>\n";
            print "<form method=post action=form.cgi>\n";
            print "<input type=hidden name=data_id value=$data_id>\n";
            print "<input type=hidden name=g_id_1 value=$g_id_1><input type=hidden name=g_id_2 value=$g_id_2>\n";
            print "<input type=hidden name=g_naiyou value=$g_naiyou>\n" ;
            print "<input type=hidden name=mode value=mail_edit_1>";
            print "<input type=submit value=�ݒ�>";
            print "</form>";
            print "</td>\n";
            print "<td>\n";
            print "<form method=post action=form.cgi>";
            print "<input type=hidden name=data_id value=$data_id>\n";
            print "<input type=hidden name=g_id_1 value=$g_id_1><input type=hidden name=g_id_2 value=$g_id_2>\n";
            print "<input type=hidden name=g_naiyou value=$g_naiyou>\n" ;
            print "<input type=hidden name=mode value=ad_del_1>";
            print "<input type=submit value=�폜>";
            print "</form>";
            print "</td>";
            print <<"EOF";
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <br>
EOF
        }
    print "<center><a href=$main_url>�߂�</a><br><br></center>\n";
    &html_footer;
    print "</body></html>\n";

    }
}

sub ad_regist_1 {

$ad_file_1 = "$dir3/data.cgi";

open (IN,"$ad_file_1") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
@LINESAD1 = <IN>;
close (IN);
$id = @LINESAD1;

foreach ( @LINESAD1 ) {
    ($id,$g_id_1,$g_id_2,$g_naiyou) = split (/\,/,$_);
    if ($g_id_1 eq $FORM{'g_id_1'} && $g_id_2 eq $FORM{'g_id_2'} ) { 
        &error ('�G���[','���w���ID�͂��łɎg���Ă��܂�'); 
    } elsif ( $FORM{'g_naiyou'} eq '' ) {
        &error ('�G���[','���l����͂��ĉ�����'); 
    }
}

open (OUT,">>$ad_file_1") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
$id++;
print OUT "$id,$FORM{'g_id_1'},$FORM{'g_id_2'},$FORM{'g_naiyou'}\n";
close (OUT);
chmod (0644,$ad_file_1);

&admin_2('$pass','�w�肵���f�[�^��o�^���܂���');

}

sub ad_edit_1 {

$ad_file_1 = "$dir3/data.cgi";
open (IN,"$ad_file_1") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
@LINES_AD_1 = <IN>;
close (IN);

    foreach (@LINES_AD_1 ) {
        ($data_id,$g_id_1,$g_id_2,$g_naiyou) = split (/\,/,$_);
        if ( $data_id eq $FORM{'data_id'}) {
            $_ = "$FORM{'data_id'},$FORM{'g_id_1'},$FORM{'g_id_2'},$FORM{'g_naiyou'}\n";
            push (@new,$_);
        } else {
            push (@new,$_);
        }

    }

open (OUT,">$ad_file_1") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
print OUT (@new);
close (OUT);
chmod (0644,$ad_file_1);
&admin_2('$pass','�w�肵���f�[�^���C�����܂���');
}

sub ad_del_1 {

$ad_file_1 = "$dir3/data.cgi";
open (IN,"$ad_file_1") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
@LINES_AD_1 = <IN>;
close (IN);

    foreach (@LINES_AD_1 ) {

        ($data_id,$g_id_1,$g_id_2,$g_naiyou) = split (/\,/,$_);

        if ( $data_id ne $FORM{'data_id'}) { 
            push (@new,$_);
        }
    }

open (OUT,">$ad_file_1") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
print OUT (@new);
close (OUT);
chmod (0644,$ad_file_1);
&admin_2('$pass','�w�肵���f�[�^���폜���܂���');
}

sub mail_edit_1 {

    print "Content-type: text/html\n\n";
    print "<html><head><title>$main_title</title>\n";
    &style;
    print "<META content=\"text/html; charset=Shift_JIS\" http-equiv=Content-Type>\n";
    print "<META content=text/css http-equiv=Content-Style-Type>\n";
    print <<"EOF";
    </head>
    $body
EOF
    &html_header;
    print <<"EOF";
    <br>
    <table align=center bgcolor=#000000 border=0 cellpadding=0 cellspacing=0 width=650>
      <tr>
        <td>
          <table border=0 cellpadding=8 cellspacing=1 width=100%>
            <tr bgcolor=#ccffcc>
              <td align=center>
                <font color="#000000" size="3"><b>[$FORM{'g_naiyou'}]�ݒ�ύX</b></font>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br>

EOF
    # mail_edit_1
    $res_mail_fillename = "$FORM{'g_id_1'}-$FORM{'g_id_2'}";
    $res_mail_file = "$dir3/$res_mail_fillename.cgi";
    # mail_edit_2
    $res_mail_fillename2 = "$FORM{'g_id_1'}-$FORM{'g_id_2'}_2";
    $res_mail_file2 = "$dir3/$res_mail_fillename2.cgi";

    if (!-e $res_mail_file ) {

    print <<"EOF";

    <form method=post action=form.cgi>
      <input type=hidden name=g_naiyou value=$FORM{'g_naiyou'}>
      <input type=hidden name=g_id_1 value=$FORM{'g_id_1'}>
      <input type=hidden name=g_id_2 value=$FORM{'g_id_2'}>

      <!-- mail_edit_2 -->
      <table border=0 cellpadding=0 align=center width=650 cellspacing=0 bgcolor=$color1>
        <tr>
          <td>
            <table border=0 width=100% cellpadding=10 cellspacing=1>
              <tr bgcolor=#ccffcc>
                <td align=center><font color=#000000>ID</font></td>
                <td align=center><font color=#000000>$FORM{'g_id_1'}-$FORM{'g_id_2'}</font></td>
              </tr>
              <tr bgcolor=#ffffff>
                <td>��M�惁�[���A�h���X</td>
                <td><input type=text name=ad_email size=50><br></td>
              </tr>
              <tr bgcolor=#ffffff>
                <td>���͊m�F�y�[�W</td>
                <td><input type=text name=ad_view size=50 value=$ad_view><br></td>
              </tr>
              <tr bgcolor=#ffffff>
                <td>�A���y�[�W</td>
                <td><input type=text name=ad_ref size=50><br></td>
              </tr>
              <tr bgcolor=#ffffff>
                <td>�K�{����</td>
                <td>
                  <input type=text name=ad_hissu size=50><br>
                  �������ڂ��w�肷��ꍇ�́F�i���p�R�����j�ŋ�؂�B<br>�Ȃ��A�`�F�b�N�{�b�N�X�ł͗��p�s�B
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <!-- mail_edit_1 -->
      <table border=0 cellpadding=0 align=center width=650 cellspacing=0 bgcolor=$color1>
        <tr>
          <td>
            <table border=0 width=100% cellpadding=10 cellspacing=1>
              <tr bgcolor=#ffffff>
                <td>
                  ���M���[�������F<br><input type=text name=m_subject size=75><hr noshade size=1>
                  ���M���[���{���㕔�F<br><textarea name=m_honbun_up cols=75 rows=5></textarea><hr noshade size=1>
                  ���M���[���{�������F<br><textarea name=m_honbun_down cols=75 rows=10></textarea><hr noshade size=1>
                  �����F<br><textarea name=m_syomei cols=50 rows=5></textarea>
                  <hr noshade size=1>
                  <input type=radio name=mode value=mail_edit_view checked>�v���r���[
                  <input type=radio name=mode value=mail_edit_regist>�o�^
                  <input type=submit value=���s> <input type=reset value=���Z�b�g>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>

EOF

    } else {

    # mail_edit_1
    open (IN,"$res_mail_file") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
    @LINES_AD_2 = <IN>;
    close (IN);

    ($m_subject,$m_honbun_up,$m_honbun_down,$m_syomei) = split (/\,/,$LINES_AD_2[0]);

    $m_honbun_up =~ s/<br>/\n/g;
    $m_honbun_down =~ s/<br>/\n/g;
    $m_syomei =~ s/<br>/\n/g;

    # mail_edit_2
    open (IN,"$res_mail_file2") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
    @LINES_AD_2 = <IN>;
    close (IN);

#   �m�F��ʂ̓ǂݍ��݂�ǉ�
    ($ad_email,$ad_view,$ad_ref,$ad_hissu) = split (/\,/,$LINES_AD_2[0]);

    print <<"EOF";
    <div align=center><b>$_[0]</b></div>
    <form method=post action=form.cgi>
      <input type=hidden name=g_naiyou value=$FORM{'g_naiyou'}>
      <input type=hidden name=g_id_1 value=$FORM{'g_id_1'}>
      <input type=hidden name=g_id_2 value=$FORM{'g_id_2'}>

      <!-- mail_edit_2 -->
      <table border=0 cellpadding=0 align=center width=650 cellspacing=0 bgcolor=$color1>
        <tr>
          <td>
            <table border=0 width=100% cellpadding=10 cellspacing=1>
              <tr bgcolor=#ccffcc>
                <td align=center><font color=#000000>ID</font></td>
                <td align=center><font color=#000000>$FORM{'g_id_1'}-$FORM{'g_id_2'}</font></td>
              </tr>
              <tr bgcolor=#ffffff>
                <td>��M�惁�[���A�h���X</td>
                <td><input type=text name=ad_email size=50 value=$ad_email><br></td>
              </tr>
              <tr bgcolor=#ffffff>
                <td>���͊m�F�y�[�W</td>
                <td><input type=text name=ad_view size=50 value=$ad_view><br></td>
              </tr>
              <tr bgcolor=#ffffff>
                <td>�A���y�[�W</td>
                <td><input type=text name=ad_ref size=50 value=$ad_ref><br></td>
              </tr>
              <tr bgcolor=#ffffff>
                <td>�K�{����</td>
                <td>
                  <input type=text name=ad_hissu size=50 value=$ad_hissu><br>
                  �������ڂ��w�肷��ꍇ�́F�i���p�R�����j�ŋ�؂�B<br>�Ȃ��A�`�F�b�N�{�b�N�X�ł͗��p�s�B
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <!-- mail_edit_1 -->
      <table border=0 cellpadding=0 align=center width=650 cellspacing=0 bgcolor=$color1>
        <tr>
          <td>
            <table border=0 width=100% cellpadding=10 cellspacing=1>
              <tr bgcolor=#ffffff>
                <td>
                  ���M���[�������F<br><input type=text name=m_subject size=75 value="$m_subject"><hr noshade size=1>
                  ���M���[���{���㕔�F<br><textarea name=m_honbun_up cols=75 rows=5>$m_honbun_up</textarea><hr noshade size=1>
                  ���M���[���{�������F<br><textarea name=m_honbun_down cols=75 rows=10>$m_honbun_down</textarea><hr noshade size=1>
                  �����F<br><textarea name=m_syomei cols=50 rows=5>$m_syomei</textarea>
                  <hr noshade size=1>
                  <input type=radio name=mode value=mail_edit_view checked>�v���r���[
                  <input type=radio name=mode value=mail_edit_regist>�o�^
                  <input type=submit value=���s> <input type=reset value=���Z�b�g>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>

EOF
    }

    print <<"EOF";

    <form method=post action=form.cgi>
      <input type=hidden name=mode value=admin_2>
      <input type=hidden name=pass value=$pass>
      <input type=submit value=�O�̃y�[�W�֖߂�>
    </form>

EOF
    &html_footer;
    print "</body></html>\n";
    exit;
}

sub mail_edit_regist {
if ( $FORM{'m_subject'} eq '' || $FORM{'ad_email'} eq '' || $FORM{'ad_view'} eq '' || $FORM{'ad_ref'} eq '' || $FORM{'ad_hissu'} eq '' ) {
    &error ('�G���[','��M�惁�[���A�h���X�A���͊m�F�y�[�W�A�A���y�[�W�A�K�{���ځA ���M���[�������͕K�����͂��Ă��������B');
}


# mail_edit_1

$res_mail_fillename = "$FORM{'g_id_1'}-$FORM{'g_id_2'}";
$res_mail_file = "$dir3/$res_mail_fillename.cgi";

open (OUT,">$res_mail_file") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
print OUT "$FORM{'m_subject'},$FORM{'m_honbun_up'},$FORM{'m_honbun_down'},$FORM{'m_syomei'}";
close (OUT);
chmod (0644,$res_mail_file);


# mail_edit_2

$res_mail_fillename2 = "$FORM{'g_id_1'}-$FORM{'g_id_2'}_2";
$res_mail_file2 = "$dir3/$res_mail_fillename2.cgi";

open (OUT,">$res_mail_file2") || &error('�I�[�v���G���[','�w�肳�ꂽ�����݃t�@�C�����J���܂���B');
print OUT "$FORM{'ad_email'},$FORM{'ad_view'},$FORM{'ad_ref'},$FORM{'ad_hissu'}\n";
close (OUT);
chmod (0644,$res_mail_file2);

&mail_edit_1('�o�^/�C�����܂����B');


EOF
}

sub mail_edit_view {

 $m_honbun_up = $FORM{'m_honbun_up'};
 $m_honbun_up =~ s/&lt;br&gt;/<br>/g;

 $m_honbun_down = $FORM{'m_honbun_down'};
 $m_honbun_down =~ s/&lt;br&gt;/<br>/g;

 $m_syomei = $FORM{'m_syomei'};
 $m_syomei =~ s/&lt;br&gt;/<br>/g;

print "Content-type: text/html\n\n";
print "<html><head><title>$main_title</title>\n";
print <<"EOF";
</head>$body

<table border=0 cellpadding=0 align=center width=600 cellspacing=0 bgcolor=$color1><tr><td>
<table border=0 width=100% cellpadding=3 cellspacing=1 cellpadding=3>
<tr bgcolor=$color2><td align=center>
<b>���M���[���v���r���[
</td></tr></table></td></tr></table><br>
<table border=1 align=center bordercolor=#cccccc cellspacing=1 cellpadding=20><tr><td>
<font size=2>
==================================================<br>
$FORM{'m_subject'}<br>
==================================================<br>
<br>
$m_honbun_up<br>
<br>
--------------------------------------------------<br>
�����ɐݒ�t�H�[������̃f�[�^�����͂���܂�<br>
<br>
�����F���ږ�<br>xx�F���[�U�[�̋L�����e<p>
���� = xxxx(�f�[�^�ɉ��s���Ȃ��ꍇ)<br>
������ =�i�f�[�^�ɉ��s������ꍇ)<br>
<br>
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br>
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br>
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br>
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br>
xxxxxxxxxxxxxxxxxxxxxx<br>
<br>
���ڂ̐��͖������ł��B<br>
--------------------------------------------------<br>
$m_honbun_down<br>
<br>
$m_syomei
</td></tr></table><p>
<center>
�u���E�U�̖߂�{�^���Ŗ߂��Ă��������B
</center>
</body></html>
EOF
exit;
}

# ======================================================

#-----[ sylph+ ���b�N�֐� ]
sub lock_d {
    local($retry,$flag);

    if ($lockfile eq "") {
        &error('�V�X�e���ُ� 106','�\���󂠂�܂��񂪉��炩�̌����ŏ����ł��܂���.');
    }

    # mkdir ���b�N
    if (-e $lockfile) {
        # ���b�N����������($waitmin)�ꍇ�ɂُ͈�Ɣ��f���č폜����
        if ((-M $lockfile) * 60 * 60 * 24 > $waitmin * 60) {
            rmdir($lockfile);
        }
    }

    $flag = 0;
    foreach (1 .. 5) {
        if (-e $lockfile) { sleep(1); }
        else {
            if (!mkdir($lockfile, 0777)) {
                select(undef, undef, undef, 1.0);
                last;
            }else{
                $flag = 1;
                last;
            }
        }
    }
    if ($flag == 0) { &error('�V�X�e���ُ� 105','���݁A��ύ��G���Ă���܂��B<br>�u�߂�v�{�^���ōēx�̑��M���A���肢�������܂��B'); }
}

#-----[ sylph+ �A�����b�N�֐� ]
sub unlock_d {
    if (-e $lockfile) { rmdir($lockfile); }
}

# �X�N���v�g�I��============================================================================

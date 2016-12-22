#!/usr/bin/python
import subprocess
import sys, os
import ftplib

FTP_SERVER = 'xxx'
FTP_USER = 'xxx'
FTP_PASS = 'xxx'

#------------------------------------------------------------------------------
def main(argv):

    modified_files = []

    # get the modified filelist from git
    process = subprocess.Popen("git status --porcelain", stdout=subprocess.PIPE, shell=True)
    output = process.communicate()[0];

    # take only care of the modified file, line start with 'M'
    for line in output.split("\n"):
        print line
        if line[:3] == ' M ':
            modified_files.append(line[3:])

    upload_files(modified_files)

#------------------------------------------------------------------------------
def upload_files(file_list):

    ftp = ftplib.FTP(FTP_SERVER)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.cwd('phpvms')

    # save the start directories to go back there
    remote_dir = ftp.pwd()
    local_dir = os.getcwd()

    for filename in file_list:

        if os.path.isfile(filename):

            # extract directory only and file name
            pos = filename.rfind('/')
            directory = filename[:pos]
            fileonly = filename[pos+1:]

            print "== " + filename

            # change the local directory
            os.chdir(directory)
            print "l : " + os.getcwd()

            # change the remote ftp directory
            ftp.cwd(directory)
            print "r : " + ftp.pwd()

            # transfer the file
            print " -> " + fileonly
            ftp.storbinary('STOR ' + fileonly, open(fileonly, 'rb'))

            # go back to the start directory
            os.chdir(local_dir)
            ftp.cwd(remote_dir)

        else:

            print "file not found : " + filename


    ftp.quit()

if __name__ == "__main__":
    main(sys.argv)

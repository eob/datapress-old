import os
import os.path
import sys
import shutil 

def copy_files(other_root, my_root, sub_dir):
    files = os.listdir(os.path.join(my_root, sub_dir))
    for f in files:        
        if (os.path.isdir(os.path.join(my_root, sub_dir, f))):
            if (not (f == ".svn")):
                # Make the new directory
                os.mkdir(os.path.join(other_root, sub_dir, f))
                copy_files(other_root, my_root, os.path.join(sub_dir, f))
        else:
            shutil.copyfile(os.path.join(my_root, sub_dir, f), os.path.join(other_root, sub_dir, f))

def doit(args):
    version = args[0]
    wordpress = args[1]
    
    # make the new directory
    newdir = os.path.join(wordpress, 'tags', version)
    print "Making directory %s" % newdir
    os.mkdir(newdir)
    
    # Now copy the files
    print "Copying over files"
    copy_files(newdir, 'plugin', '.')
    
    print "Your instructions: "
    print "1) svn add the new directory and commit the changes"
    print "2) modify readme.txt in the trunk to point to this version number"

def main(args):
    if (len(args) != 2):
        print "Usage: "
        print "python deploy_to_wordpress_dot_com.py <Version> <WordPress SVN Dir>"
        print ""
        print "1) Pick a version number of format #.#.#"
        print "2) Then run this script."
    else:
        doit(args)
        
if __name__ == "__main__":
    doit(sys.argv[1:])
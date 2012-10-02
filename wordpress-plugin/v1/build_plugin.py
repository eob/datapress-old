import os
import os.path
import tempfile
import shutil
import subprocess
import zipfile

PLUGIN_FOLDER = "datapress"
ZIP_NAME = "datapress.zip"

def kill_svn(root_dir):
    files = os.listdir(root_dir)
    for f in files:
        if (f == ".svn"):
            shutil.rmtree(os.path.join(root_dir,f))
        elif (os.path.isdir(os.path.join(root_dir, f))):
            kill_svn(os.path.join(root_dir, f))

def write_to_zip(zipfile, root_dir, local_dir):
    files = os.listdir(os.path.join(root_dir, local_dir))
    for f in files:        
        if (os.path.isdir(os.path.join(root_dir, local_dir, f))):
            write_to_zip(zipfile, root_dir, os.path.join(local_dir, f))
        else:
            zipfile.write(os.path.join(root_dir, local_dir, f), os.path.join(local_dir, f))

tempdir = tempfile.mkdtemp()

print "Copying Files..."
shutil.copytree('plugin', os.path.join(tempdir, PLUGIN_FOLDER))

plugindir = os.path.join(tempdir, PLUGIN_FOLDER)
print "Plugin Folder: " + plugindir

print "Removing .svn Directories"
kill_svn(tempdir)

print "Zipping"

z = zipfile.ZipFile(ZIP_NAME, 'w')
write_to_zip(z, tempdir, PLUGIN_FOLDER)

shutil.rmtree(tempdir)
#!/usr/bin/env python
# encoding: utf-8
"""
package.py

Packages the DataPress plugin

Created by Ted Benson on 25 Oct 2012.
"""
import os
import sys
import logging
import optparse
import shutil
import glob
import re

def getSnippit(filename, snippit):
  fname = os.path.join("../", filename)
  fin = open(fname)
  html = "".join(fin.readlines())
  fin.close()
  opener = "begin-snippit:%s" % snippit 
  closer = "end-snippit:%s" % snippit 
  print opener
  print closer
  print html
  opener = "<!-- begin-snippit:%s -->" % snippit 
  closer = "<!-- end-snippit:%s -->" % snippit 
  regex = re.compile(r"%s(.*)%s" % (opener, closer), re.DOTALL)
  result = re.search(regex, html) 
  print result
  return result.group(0)

def template(filename):
  inf = open(filename)
  lines = inf.readlines()
  inf.close()
  outlines = []
  hadTemplate = False
  for line in lines:
    if line.startswith("##INCLUDE:"):
      hadTemplate = True
      parts = line.strip().split(":")
      snippit = getSnippit(parts[1], parts[2]) 
      outlines.append(snippit + "\n")
    else:
      outlines.append(line)
  if hadTemplate:
    print "    * Had template"
    # delete the file, write in the new one
    os.remove(filename)
    outf = open(filename, 'w')
    for line in outlines:
      outf.write(line)
    outf.close()


def process_command_line(argv):
  """
  Return a 2-tuple: (settings object, args list).
  `argv` is a list of arguments, or `None` for ``sys.argv[1:]``.
  """
  if argv is None:
    argv = sys.argv[1:]
 
  # initialize the parser object:
  parser = optparse.OptionParser(
  formatter=optparse.TitledHelpFormatter(width=78),
  add_help_option=None)
 
  # define options here:
  parser.add_option("-i", "--inputdir", dest="indir", 
                    help="Input Directory (default: ../)", default="../")
  parser.add_option("-o", "--outputdir", dest="outdir", 
                    help="Output Directory (default = target)", default="target")
  parser.add_option("-s", "--source", dest="source", 
                    help="Scaffold Directory (default = ../plugin)", default="../plugin")
  parser.add_option("-b", "--blast", action="store_true", dest="blast", 
                    help="Blast away existing files in output dir?", default=False)
  parser.add_option(      # customized description; put --help last
  '-h', '--help', action='help',
  help='Show this help message and exit.')
 
  options, args = parser.parse_args(argv)
 
  # check number of arguments, verify values, etc.:
 
  return options, args

def run(settings):
  print "Settings: %s" % str(settings)
  # --------------------------------------------------------------
  # Step 1: Create the output directory. 
  # Fail if it already exists and blast option hasn't been added
  print "# Step 1: Copy source to output directory"
  if os.path.exists(settings.outdir):
    if settings.blast:
      print "  - Blasting existing output directory"
      shutil.rmtree(settings.outdir)
      shutil.copytree(settings.source, settings.outdir)
    else:
      print "ERROR: Output directory exists! Use --blast option to wipe it away."
      return
  else:
    print "  - Creating new output directory"
    shutil.copytree(settings.source, settings.outdir)

  # --------------------------------------------------------------
  # Step 2: 
  print "# Step 2: Copy in snippets"
  dirs = [ settings.outdir ]
  extensions = ["php", "php4", "php5"]

  while len(dirs) > 0:
    path = dirs.pop()
    for filename in glob.glob(os.path.join(path, "*")):
      if os.path.isdir(filename):
        dirs.append(filename)
      else:
        templ = False
        for ex in extensions:
          if filename.endswith(ex):
            templ = True
        if templ:
          print "  - Templating: %s" % filename
          template(filename)

def main(argv=None):
  settings, args = process_command_line(argv)
  # application code here, like:
  run(settings)
  return 0        # success

if __name__ == '__main__':
  status = main()
  sys.exit(status)
